export const numericFormat = (evt, data, max_length) => {
    evt = (evt) ? evt : window.event;
    let charCode = (evt.which) ? evt.which : evt.keyCode;
    let keys = [46, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57];
    let validIndex = keys.indexOf(charCode);
    if (validIndex === -1 || String(data).length > max_length) {
        event.preventDefault();
    }
}
