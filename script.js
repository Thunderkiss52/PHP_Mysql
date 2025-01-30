const submit_btn = document.getElementById("submit"); // Get the submit button element
const data_table = document.getElementById("data"); // Get the data table element
const transactionsBody = document.getElementById("transactions-body"); // Get the body of the transactions table
const userNameSpan = document.getElementById("user-name"); // Get the span element for displaying the user's name

submit_btn.onclick = function (e) {
  e.preventDefault(); // Prevent the default behavior of the submit button

  const userSelect = document.getElementById("user"); // Get the user select dropdown
  const userId = userSelect.value; // Get the selected user ID
  const userName = userSelect.options[userSelect.selectedIndex].text; // Get the name of the selected user

  data_table.style.display = "block"; // Show the data table
  userNameSpan.textContent = userName; // Set the user's name in the header

  // Fetch transaction data for the selected user
  fetch(`data.php?user=${userId}`)
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then(transactions => {
        transactionsBody.innerHTML = ""; // Clear the table body before adding new data
        if (transactions.length > 0) { // Check if there are any transactions
          transactions.forEach(transaction => {
            const row = document.createElement('tr');
            row.innerHTML = `<td>${transaction.month}</td><td>${transaction.amount}</td>`; // Set the row's HTML with transaction data
            transactionsBody.appendChild(row);
          });
        } else {
          const row = document.createElement('tr');
          row.innerHTML = `<td colspan="2">No transactions for this user.</td>`; // Set the row's HTML to indicate no transactions
          transactionsBody.appendChild(row);
        }
      })
      .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
      });
};
