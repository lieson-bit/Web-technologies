// Student Class Implementation
class Student {
    constructor(name, age, gpa) {
        // Protected properties convention using underscore
        this._name = this.validateName(name);
        this._age = this.validateAge(age);
        this._gpa = this.validateGPA(gpa);
    }

    // Validation methods
    validateName(name) {
        if (typeof name === 'string' && name.trim().length >= 2) {
            return name.trim();
        }
        throw new Error('Invalid name: Must be at least 2 characters');
    }

    validateAge(age) {
        const num = Number(age);
        if (Number.isInteger(num) && num >= 16 && num <= 25) {
            return num;
        }
        throw new Error('Invalid age: Must be between 16-25');
    }

    validateGPA(gpa) {
        const num = Number(gpa);
        if (!isNaN(num) && num >= 0 && num <= 4.0) {
            return Math.round(num * 100) / 100; // Round to 2 decimals
        }
        throw new Error('Invalid GPA: Must be between 0-4.0');
    }

    // Accessor methods
    get name() {
        return this._name;
    }

    set name(newName) {
        this._name = this.validateName(newName);
    }

    get age() {
        return this._age;
    }

    set age(newAge) {
        this._age = this.validateAge(newAge);
    }

    get gpa() {
        return this._gpa;
    }

    set gpa(newGPA) {
        this._gpa = this.validateGPA(newGPA);
    }

    // Utility methods
    getStudentInfo() {
        return {
            name: this._name,
            age: this._age,
            gpa: this._gpa
        };
    }
}

// Create initial student instance
let student = new Student('Alice Johnson', 18, 3.75);

// Display initial values
function refreshDisplay() {
    const info = student.getStudentInfo();
    document.getElementById('nameDisplay').textContent = 
        `Name: ${info.name}`;
    document.getElementById('ageDisplay').textContent = 
        `Age: ${info.age} years`;
    document.getElementById('gpaDisplay').textContent = 
        `GPA: ${info.gpa.toFixed(2)}`;
}

// Update functions with error handling
function updateName() {
    const input = document.getElementById('nameInput');
    const message = document.getElementById('nameMessage');
    
    try {
        student.name = input.value;
        message.textContent = 'Name updated successfully!';
        message.className = 'success';
        input.value = '';
        refreshDisplay();
    } catch (error) {
        message.textContent = error.message;
        message.className = 'error';
    }
}

function updateAge() {
    const input = document.getElementById('ageInput');
    const message = document.getElementById('ageMessage');
    
    try {
        student.age = input.value;
        message.textContent = 'Age updated successfully!';
        message.className = 'success';
        input.value = '';
        refreshDisplay();
    } catch (error) {
        message.textContent = error.message;
        message.className = 'error';
    }
}

function updateGPA() {
    const input = document.getElementById('gpaInput');
    const message = document.getElementById('gpaMessage');
    
    try {
        student.gpa = input.value;
        message.textContent = 'GPA updated successfully!';
        message.className = 'success';
        input.value = '';
        refreshDisplay();
    } catch (error) {
        message.textContent = error.message;
        message.className = 'error';
    }
}

// Initial display
refreshDisplay();
