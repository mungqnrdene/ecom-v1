# 5-Minute Refund Window Implementation

## Summary

Implemented a 5-minute refund window for orders. Users can only refund orders within 5 minutes of creation.

## Backend Changes

### OrderController.php

Added time-based validation in the `refund()` method:

```php
// Check 5-minute refund window
$refundDeadline = $order->created_at->copy()->addMinutes(5);
if (now()->greaterThan($refundDeadline)) {
    return back()->withErrors(['error' => 'Буцаалтын хугацаа дууссан байна...']);
}
```

**Validation Logic:**

1. Authorization check (user owns order)
2. Already refunded check (status === 'refunded')
3. **NEW:** Time window check (created_at + 5 minutes > now)

## UI Changes

### Order Index Page (users/orders/index.blade.php)

**Before:** Showed refund button for all non-refunded orders

**After:**

-   Calculates refund deadline: `$refundDeadline = $order->created_at->copy()->addMinutes(5)`
-   Shows refund button only if `now() <= refundDeadline`
-   Shows disabled "Хугацаа дууссан" button if time expired

```php
@php
    $refundDeadline = $order->created_at->copy()->addMinutes(5);
    $canRefund = now()->lessThanOrEqualTo($refundDeadline) && $order->status !== 'refunded';
@endphp
```

### Order Show Page (users/orders/show.blade.php)

**Enhanced with:**

1. **Alert Message:** Shows "5 минутын дотор буцаалт хийх боломжтой"
2. **Live Countdown Timer:** JavaScript countdown showing remaining time (MM:SS)
3. **Expired Warning:** Shows yellow alert when 5 minutes passed
4. **Auto-refresh:** Page reloads when timer reaches 0

**Countdown Script:**

```javascript
let timeLeft = {{ $timeRemaining }};
const timer = setInterval(() => {
    timeLeft--;
    if (timeLeft <= 0) {
        location.reload(); // Refresh to show expired state
    } else {
        // Update countdown display
        countdownEl.textContent = `${minutes}:${seconds}`;
    }
}, 1000);
```

## Security Features

### ✅ Backend Validation

-   Cannot bypass via direct POST request
-   Time check happens server-side
-   Returns error message if time expired

### ✅ Authorization

-   User must own the order
-   Cannot refund another user's order
-   403 Forbidden if unauthorized

### ✅ Status Check

-   Cannot refund already refunded orders
-   Prevents double refunds

## User Experience

### Within 5 Minutes:

1. **Order List:** Green "Буцаах" button visible
2. **Order Details:**
    - Blue info alert with countdown
    - Active refund button
    - Live timer showing remaining time

### After 5 Minutes:

1. **Order List:** Gray disabled button "Хугацаа дууссан"
2. **Order Details:**
    - Yellow warning alert
    - No refund button
    - Message: "Буцаалтын хугацаа дууссан"

### On Refund Attempt After Expiry:

-   Backend returns error: "Буцаалтын хугацаа дууссан байна. Захиалга үүссэнээс хойш зөвхөн 5 минутын дотор буцаалт хийх боломжтой."

## Testing Scenarios

### Test 1: Fresh Order (< 5 minutes)

```
1. Create new order
2. Go to order details
3. ✅ Should see countdown timer
4. ✅ Should see active refund button
5. Click refund
6. ✅ Should successfully refund
```

### Test 2: Expired Order (> 5 minutes)

```
1. Find order older than 5 minutes
2. Go to order details
3. ✅ Should see "Хугацаа дууссан" warning
4. ✅ Should NOT see refund button
5. Try to refund via direct POST
6. ✅ Should get error message
```

### Test 3: Already Refunded Order

```
1. Refund an order
2. Try to refund again
3. ✅ Should get "аль хэдийн буцаагдсан" error
```

### Test 4: Countdown Timer

```
1. Create order
2. Go to details immediately
3. ✅ Should see countdown near 05:00
4. Wait and observe
5. ✅ Timer should count down
6. Wait until 00:00
7. ✅ Page should auto-reload
8. ✅ Should show expired warning
```

## Database Fields Used

-   `orders.created_at` - Order creation timestamp
-   `orders.status` - Order status (pending/refunded/etc)
-   `orders.refunded_at` - Refund timestamp (set when refunded)
-   `orders.payment_status` - Payment status (refunded)

## Files Modified

1. **app/Http/Controllers/OrderController.php**
    - Added 5-minute time check in `refund()` method
2. **resources/views/users/orders/index.blade.php**

    - Added conditional button display logic
    - Shows disabled button when expired

3. **resources/views/users/orders/show.blade.php**
    - Added countdown timer
    - Added info/warning alerts
    - Added auto-refresh script

## Configuration

To change the refund window duration, update in **3 places**:

1. **OrderController.php** line ~123:

    ```php
    $refundDeadline = $order->created_at->copy()->addMinutes(5); // Change 5
    ```

2. **orders/index.blade.php** line ~172:

    ```php
    $refundDeadline = $order->created_at->copy()->addMinutes(5); // Change 5
    ```

3. **orders/show.blade.php** line ~189:
    ```php
    $refundDeadline = $order->created_at->copy()->addMinutes(5); // Change 5
    ```

## Future Enhancements (Optional)

-   [ ] Admin can override time limit
-   [ ] Email notification when refund window expires
-   [ ] Configurable refund window per product category
-   [ ] Refund window settings in admin panel
-   [ ] Partial refunds within extended timeframe

## Implementation Complete ✅

All requirements met:

-   ✅ 5-minute time limit enforced
-   ✅ Backend validation prevents bypassing
-   ✅ UI shows/hides refund button appropriately
-   ✅ Live countdown timer for user feedback
-   ✅ Cannot refund expired orders
-   ✅ Cannot refund same order twice
