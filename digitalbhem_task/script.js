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
            alert("Please enter a valid amount for the transfer.");
            return;
        }

        if (accountBalances[fromAccount] >= amount) {
            accountBalances[fromAccount] -= amount;
            accountBalances[toAccount] += amount;
            updateAccountBalance();
            showAlert(`Successfully transferred $${amount} from ${fromAccount} to ${toAccount}.`);
        } else {
            alert("Insufficient balance in the selected account.");
        }
    });

    const payBillBtn = document.getElementById("pay-bill-btn");

    payBillBtn.addEventListener("click", function () {
        const billType = document.getElementById("bill-type").value;
        const billAmount = parseFloat(document.getElementById("bill-amount").value);

        if (isNaN(billAmount) || billAmount <= 0) {
            alert("Please enter a valid bill amount.");
            return;
        }

        showAlert(`Paid $${billAmount} for ${billType} bill.`);
    });

    const purchaseBtn = document.getElementById("purchase-btn");

    purchaseBtn.addEventListener("click", function () {
        const productName = document.getElementById("product").value;
        const purchaseAmount = parseFloat(document.getElementById("purchase-amount").value);

        if (isNaN(purchaseAmount) || purchaseAmount <= 0) {
            alert("Please enter a valid purchase amount.");
            return;
        }

        showAlert(`Purchased ${productName} for $${purchaseAmount}.`);
    });

    function updateAccountBalance() {
        accountBalanceElement.textContent = `$${accountBalances.savings} (Savings), $${accountBalances.checking} (Checking)`;
    }

    function showAlert(message) {
        const modal = document.createElement("div");
        modal.className = "modal";
        modal.innerHTML = `
            <div class="modal-content">
                <span class="close">&times;</span>
                <p>${message}</p>
            </div>
        `;

        document.body.appendChild(modal);

        const closeModal = () => {
            document.body.removeChild(modal);
        };

        const closeBtn = modal.querySelector(".close");
        closeBtn.addEventListener("click", closeModal);

        setTimeout(closeModal, 5000);
    }
});
