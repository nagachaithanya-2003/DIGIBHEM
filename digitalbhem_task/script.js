document.addEventListener("DOMContentLoaded", function () {
    const transferForm = document.getElementById("transfer-form");
    const transferBtn = document.getElementById("transfer-btn");
    const accountBalanceElement = document.getElementById("account-balance-value");

    let accountBalances = {
        savings: 1000,
        checking: 500
    };

    updateAccountBalance();

    transferBtn.addEventListener("click", function () {
        const fromAccount = document.getElementById("from-account").value;
        const toAccount = document.getElementById("to-account").value;
        const amount = parseFloat(document.getElementById("amount").value);

        if (isNaN(amount) || amount <= 0) {
            alert("Please enter a valid amount.");
            return;
        }

        if (accountBalances[fromAccount] >= amount) {
            accountBalances[fromAccount] -= amount;
            accountBalances[toAccount] += amount;
            updateAccountBalance();
            alert(`Successfully transferred $${amount} from ${fromAccount} to ${toAccount}.`);
        } else {
            alert("Insufficient balance in the selected account.");
        }
    });

    function updateAccountBalance() {
        accountBalanceElement.textContent = `$${accountBalances.savings} (Savings), $${accountBalances.checking} (Checking)`;
    }
});
