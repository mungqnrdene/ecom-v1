<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct()
    {
        // Admin middleware бүх method-д хамаарахгүй - search method энгийн хэрэглэгчдэд зориулагдсан
        $this->middleware('auth:admin')->except(['search']);
    }

    // ================= LIST ALL PRODUCTS =================
    public function index()
    {
        $admin = Auth::guard('admin')->user();

        $products = Product::where('admin_id', $admin->id)
            ->with('category')
            ->latest()
            ->get();

        return view('admin.products.index', compact('products'));
    }

    // ================= CREATE PRODUCT FORM =================
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    // ================= STORE PRODUCT =================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'keywords'    => 'nullable|string|max:500',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['admin_id'] = Auth::guard('admin')->id();

        // Upload image
        if ($request->hasFile('image')) {
            $validated['image'] = $request
                ->file('image')
                ->store('products', 'public');
        }

        Product::create($validated);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Барааг амжилттай нэмлээ');
    }

    // ================= EDIT PRODUCT FORM =================
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $this->authorize('update', $product);

        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // ================= UPDATE PRODUCT =================
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $this->authorize('update', $product);

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'keywords'    => 'nullable|string|max:500',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Replace image if new uploaded
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $validated['image'] = $request
                ->file('image')
                ->store('products', 'public');
        }

        $product->update($validated);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Барааг амжилттай өөрчиллөө');
    }
    // ================= ADVANCED PRODUCT SEARCH =================
    /**
     * Search products with synonym mapping and relevance ordering
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $query = $request->input('q', '');

        if (strlen($query) < 2) {
            return response()->json(['products' => []]);
        }

        // Synonym mapping for better search results
        $synonymMap = [
            'утас' => ['phone', 'mobile', 'smartphone', 'iphone', 'android', 'утас', 'гар утас'],
            'phone' => ['утас', 'mobile', 'smartphone', 'гар утас'],
            'mobile' => ['утас', 'phone', 'smartphone', 'гар утас'],
            'зөөврийн' => ['laptop', 'notebook', 'компьютер'],
            'laptop' => ['зөөврийн', 'notebook', 'компьютер'],
            'чихэвч' => ['headphone', 'earphone', 'airpods', 'earbud'],
            'headphone' => ['чихэвч', 'earphone', 'airpods'],
            'цэнэглэгч' => ['charger', 'charging', 'adapter', 'power'],
            'charger' => ['цэнэглэгч', 'charging', 'adapter'],
            'кейс' => ['case', 'cover', 'хавтас', 'хамгаалалт'],
            'case' => ['кейс', 'cover', 'хавтас'],
        ];

        // Get search terms including synonyms
        $searchTerms = $this->getSearchTerms($query, $synonymMap);

        // Build complex search query with relevance scoring
        $products = Product::with('category')
            ->where(function ($q) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $q->orWhere('name', 'LIKE', "%{$term}%")
                        ->orWhere('description', 'LIKE', "%{$term}%")
                        ->orWhere('keywords', 'LIKE', "%{$term}%");
                }
            })
            // Include products from matching categories
            ->orWhereHas('category', function ($q) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $q->orWhere('name', 'LIKE', "%{$term}%");
                }
            })
            ->get()
            // Calculate relevance score and sort by it
            ->map(function ($product) use ($searchTerms) {
                $relevance = 0;

                foreach ($searchTerms as $term) {
                    // Exact match in name: highest priority
                    if (stripos($product->name, $term) !== false) {
                        $relevance += 100;
                        // Bonus for exact word match
                        if (stripos($product->name, $term) === 0) {
                            $relevance += 50;
                        }
                    }

                    // Match in category name: high priority
                    if ($product->category && stripos($product->category->name, $term) !== false) {
                        $relevance += 80;
                    }

                    // Match in keywords: medium priority
                    if ($product->keywords && stripos($product->keywords, $term) !== false) {
                        $relevance += 50;
                    }

                    // Match in description: lower priority
                    if ($product->description && stripos($product->description, $term) !== false) {
                        $relevance += 30;
                    }
                }

                $product->relevance = $relevance;
                return $product;
            })
            ->filter(function ($product) {
                return $product->relevance > 0;
            })
            ->sortByDesc('relevance')
            ->take(10)
            ->values()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price_formatted' => number_format($product->price),
                    'image' => $product->image ? asset('storage/' . $product->image) : null,
                    'category' => $product->category ? $product->category->name : null,
                ];
            });

        return response()->json(['products' => $products]);
    }

    /**
     * Get search terms including synonyms
     * 
     * @param string $query
     * @param array $synonymMap
     * @return array
     */
    private function getSearchTerms($query, $synonymMap)
    {
        $terms = [];
        $queryLower = mb_strtolower(trim($query));

        // Add original query
        $terms[] = $queryLower;

        // Add synonyms if found in map
        foreach ($synonymMap as $key => $synonyms) {
            if (stripos($queryLower, $key) !== false) {
                $terms = array_merge($terms, $synonyms);
            }
        }

        // Remove duplicates and return
        return array_unique($terms);
    }
    // ================= DELETE PRODUCT =================
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $this->authorize('delete', $product);

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Барааг амжилттай устгалаа');
    }
}
