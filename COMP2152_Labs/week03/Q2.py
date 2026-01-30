cart = ["apple", "banana", "milk", "bread", "apple", "eggs"]
apple_count = cart.count("apple")
print(f"Number of apples in the cart: {apple_count}")
milk_position = cart.index("milk")
print(f"Position of milk in the cart: {milk_position}")
cart.remove("apple")
removed_item = cart.pop()
print(f"Removed item using pop: {removed_item}")
print("Is banana in the cart:", "banana" in cart)