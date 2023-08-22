document.addEventListener("DOMContentLoaded", function () {
    const transferForm = document.getElementById("transfer-form");
    const transferBtn = document.getElementById("transfer-btn");

    transferBtn.addEventListener("click", function () {
        const fromAccount = document.getElementById("from-account").value;
        const toAccount = document.getElementById("to-account").value;
        const amount = parseFloat(document.getElementById("amount").value);

        if (isNaN(amount) || amount <= 0) {
            alert("Please enter a valid amount.");
            return;
        }

        // Perform transfer logic here (e.g., update account balances)
        alert(`Successfully transferred $${amount} from ${fromAccount} to ${toAccount}.`);
    });
});
