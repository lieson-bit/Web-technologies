const fs = require("fs");
const path = require("path");

const uploadFile = async (file) => {
    try {
        const filePath = path.join(__dirname, "../uploads", file.filename);
        return filePath; // Return the file path or URL
    } catch (error) {
        throw new Error("Failed to upload file");
    }
};

module.exports = { uploadFile };