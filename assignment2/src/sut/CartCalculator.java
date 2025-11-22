package sut;

import java.math.BigDecimal;
import java.math.RoundingMode;
import java.util.List;

public final class CartCalculator {
    private CartCalculator() {}

    // Sum price * quantity;
    // null or empty -> 0.00
    public static BigDecimal total(List<Item> items) {
        if (items == null || items.isEmpty()) return new BigDecimal("0.00");
        BigDecimal sum = BigDecimal.ZERO;
        for (Item it : items) {
            sum = sum.add(it.price().multiply(BigDecimal.valueOf(it.quantity())));
        }
        return sum.setScale(2, RoundingMode.HALF_UP);

    }

    // Apply percentage discount [0,100];
    // round HALF_UP to 2 decimals; invalid pct -> IllegalArgumentException
    public static BigDecimal applyDiscount(BigDecimal total, BigDecimal pct) {
        if (total == null || pct == null) throw new IllegalArgumentException("null");
        if (pct.compareTo(BigDecimal.ZERO) < 0 || pct.compareTo(new BigDecimal("100")) > 0)
            throw new IllegalArgumentException("pct");
        BigDecimal factor = BigDecimal.ONE.subtract(pct.movePointLeft(2));
        return total.multiply(factor).setScale(2, RoundingMode.HALF_UP);
    }
}