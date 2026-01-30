point1 = (3, 5)
point2 = (7, 2)
x1, y1 = point1
x2, y2 = point2
print(f"x1 = {x1}, y1 = {y1}")
print(f"x2 = {x2}, y2 = {y2}")
distance = ((x2 - x1) ** 2 + (y2 - y1) ** 2) ** 0.5
print(f"Distance between points: ", distance)