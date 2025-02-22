// Calculator Class
class Calculator {
    add(a, b) {
        return a + b;
    }

    subtract(a, b) {
        return a - b;
    }

    multiply(a, b) {
        return a * b;
    }

    divide(a, b) {
        if (b === 0) {
            return "Error: Division by zero!";
        }
        return a / b;
    }
}

// Function to perform calculation
function calculate() {
    const num1 = parseFloat(document.getElementById("num1").value);
    const num2 = parseFloat(document.getElementById("num2").value);
    const operation = document.getElementById("operation").value;
    const calculator = new Calculator();

    if (isNaN(num1) || isNaN(num2)) {
        document.getElementById("result").innerHTML = "Please enter valid numbers!";
        return;
    }

    let result;
    switch (operation) {
        case "add":
            result = calculator.add(num1, num2);
            break;
        case "subtract":
            result = calculator.subtract(num1, num2);
            break;
        case "multiply":
            result = calculator.multiply(num1, num2);
            break;
        case "divide":
            result = calculator.divide(num1, num2);
            break;
        default:
            result = "Invalid operation!";
    }

    document.getElementById("result").innerHTML = `Result: ${result}`;
}
