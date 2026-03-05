import supabaseClient from '/assets/js/supabase.js';

const form = document.querySelector("form");
const receiptInput = document.getElementById("receipt");
const receiptUrlInput = document.getElementById("receipt_url");
const filePreview = document.getElementById("filePreview");
const fileNameSpan = document.getElementById("fileName");

let uploaded = false;

// Upload when file selected
receiptInput.addEventListener("change", async function () {
    const file = receiptInput.files[0];
    if (!file) return;

    if (file.size > 5 * 1024 * 1024) {
        alert("File must be less than 5MB");
        receiptInput.value = "";
        return;
    }

    const fileExt = file.name.split('.').pop();
    const fileName = `claim_${Date.now()}.${fileExt}`;

    const { error } = await supabaseClient.storage
        .from("claims")
        .upload(fileName, file);

    if (error) {
        alert("Upload failed: " + error.message);
        return;
    }

    const { data } = supabaseClient.storage
        .from("claims")
        .getPublicUrl(fileName);

    receiptUrlInput.value = data.publicUrl;

    filePreview.classList.remove("hidden");
    fileNameSpan.textContent = file.name;

    uploaded = true;
});

// Prevent submit if no upload
form.addEventListener("submit", function (e) {
    if (!uploaded) {
        e.preventDefault();
        alert("Please upload receipt first.");
    }
});