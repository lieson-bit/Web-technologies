const mongoose = require('mongoose');

const PortfolioSchema = new mongoose.Schema({
    name: { type: String, required: true },
    category: { type: String, required: true },
    description: { type: String, required: true },
    projectUrl: { type: String, default: "" },
    budgetPrice: { type: Number, required: true },
    rating: { type: Number, default: 0 },
    images: [{ type: String }], // Array to store multiple images
}, { timestamps: true });

module.exports = PortfolioSchema;
