// src/helpers/formatHelpers.js

/**
 * Format amount to Rupiah currency.
 * @param {number} amount - The amount to format.
 * @returns {string} The formatted currency string.
 */
export const formatRupiah = (amount) => {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(amount);
};

/**
 * Format a date string to a readable date format.
 * @param {string} dateString - The date string to format.
 * @returns {string} The formatted date string.
 */
export const formatDate = (dateString) => {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('id-ID', options);
};
