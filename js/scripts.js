/**
 * This script contains collection of useful, simple, small javascript functions
 **/

//
/**
 * Determining whether jQuery Selector has found any element
 * Usage: $('#block-user #login-block-user').exists()
 * Returns: true if element found, false if not found
 **/
$.fn.exists = function() {
    return this.length !== 0;
}
