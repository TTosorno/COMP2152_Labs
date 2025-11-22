package sut;

import java.math.BigDecimal;
import java.util.Objects;

public final class Item {
    private final String name;
    private final BigDecimal price; // must be >= 0, scale up to 2 ok
    private final int quantity;
    // must be >= 0

    public Item(String name, BigDecimal price, int quantity) {
        if (price == null || price.signum() < 0) throw new IllegalArgumentException("price");
        if (quantity < 0) throw new IllegalArgumentException("qty");
        this.name = name;
        this.price = price;
        this.quantity = quantity;
    }

    public String name() { return name; }
    public BigDecimal price() { return price;
    }
    public int quantity() { return quantity;
    }

    @Override public boolean equals(Object o) {
        if (this == o) return true;
        if (!(o instanceof Item i)) return false;
        return quantity == i.quantity &&
                Objects.equals(name, i.name) &&
                Objects.equals(price, i.price);
    }

    @Override public int hashCode() { return Objects.hash(name, price, quantity);
    }
}