// Base Shape class
class Shape {
    constructor() {
        if (this.constructor === Shape) {
            throw new Error("Cannot instantiate an abstract class.");
        }
    }

    area() {
        throw new Error("Method 'area()' must be implemented.");
    }

    perimeter() {
        throw new Error("Method 'perimeter()' must be implemented.");
    }
}

// Rectangle class (inherits from Shape)
class Rectangle extends Shape {
    constructor(width, height) {
        super();
        this.width = width;
        this.height = height;
    }

    area() {
        return this.width * this.height;
    }

    perimeter() {
        return 2 * (this.width + this.height);
    }
}

// Circle class (inherits from Shape)
class Circle extends Shape {
    constructor(radius) {
        super();
        this.radius = radius;
    }

    area() {
        return Math.PI * Math.pow(this.radius, 2);
    }

    perimeter() {
        return 2 * Math.PI * this.radius;
    }
}

// Function to calculate rectangle properties
function calculateRectangle() {
    const width = parseFloat(document.getElementById("rect-width").value);
    const height = parseFloat(document.getElementById("rect-height").value);

    if (isNaN(width) || isNaN(height) || width <= 0 || height <= 0) {
        document.getElementById("rect-result").innerHTML = "Please enter valid dimensions.";
        return;
    }

    const rectangle = new Rectangle(width, height);
    document.getElementById("rect-result").innerHTML = `
        Area: ${rectangle.area().toFixed(2)} <br>
        Perimeter: ${rectangle.perimeter().toFixed(2)}
    `;
}

// Function to calculate circle properties
function calculateCircle() {
    const radius = parseFloat(document.getElementById("circle-radius").value);

    if (isNaN(radius) || radius <= 0) {
        document.getElementById("circle-result").innerHTML = "Please enter a valid radius.";
        return;
    }

    const circle = new Circle(radius);
    document.getElementById("circle-result").innerHTML = `
        Area: ${circle.area().toFixed(2)} <br>
        Perimeter: ${circle.perimeter().toFixed(2)}
    `;
}
