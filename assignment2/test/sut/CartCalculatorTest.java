package sut;

import org.junit.jupiter.api.Test;
import java.math.BigDecimal;
import java.util.List;
import static org.junit.jupiter.api.Assertions.*;

class CartCalculatorTest {

    // null list should return 0.00 total
    @Test
    void total_nullList_returnsZero() {
        assertEquals(new BigDecimal("0.00"), CartCalculator.total(null));
    }

    // testing one item (price * quantity)
    @Test
    void total_singleItem_calculatesPriceTimesQuantity() {
        Item item = new Item("apple", new BigDecimal("2.50"), 2);
        assertEquals(new BigDecimal("5.00"), CartCalculator.total(List.of(item)));
    }

    // more than one item should add up all totals
    @Test
    void total_multipleItems_sumsCorrectly() {
        Item a = new Item("a", new BigDecimal("1.00"), 3);
        Item b = new Item("b", new BigDecimal("0.50"), 2);
        assertEquals(new BigDecimal("4.00"), CartCalculator.total(List.of(a, b)));
    }

    // 0% discount should return the same price
    @Test
    void applyDiscount_zeroPercent_returnsSameTotal() {
        BigDecimal total = new BigDecimal("10.00");
        BigDecimal result = CartCalculator.applyDiscount(total, new BigDecimal("0"));
        assertEquals(new BigDecimal("10.00"), result);
    }

    // negative discount should not be accepted
    @Test
    void applyDiscount_negativePercent_throwsIllegalArgumentException() {
        assertThrows(IllegalArgumentException.class,
                () -> CartCalculator.applyDiscount(new BigDecimal("10.00"),
                        new BigDecimal("-5")));
    }
}