


document.addEventListener("DOMContentLoaded", function() {
    // Select the image element
    const enzo = document.getElementById('enzo');
    
    // Select the buttons
    const goldButton = document.querySelector('.gold');
    const silverButton = document.querySelector('.silver');
    const blackButton = document.querySelector('.black');

    // Define functions to change the image
    function toSilver() {
        enzo.src = 'enzo-silver.jpg';
    }

    function toBlack() {
        enzo.src = 'enzo-black.jpg';
    }

    function toGold() {
        enzo.src = 'watch1.jpg';
    }

    // Add event listeners
    goldButton.addEventListener('click', toGold);
    silverButton.addEventListener('click', toSilver);
    blackButton.addEventListener('click', toBlack);
});




function addToCart() {
    alert("ENZO COLLECTION EC209 has been added to your cart!");
}

// Function to check for empty fields
function areFieldsEmpty(fields) {
    return fields.some(value => value.trim() === "");
  }
  
  // Contact form validation
  function contact() {
    const email = document.getElementById("username").value;
    const message = document.getElementById("Message").value;
  
    if (areFieldsEmpty([email, message])) {
      alert("Please fill in all required fields.");
      return false; // Stop form submission
    }
    alert("Your message has been sent successfully!");
    return true; // Allow form submission
  }
  
  // Signup form validation
  function signup() {
    const username = document.getElementById("username").value;
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;
  
    if (areFieldsEmpty([username, email, password])) {
      alert("All fields are required.");
      return false; // Stop form submission
    }
    alert("Signup completed successfully!");
    return true; // Allow form submission
  }
  
  // Login form validation
  function login() {
    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;
  
    if (areFieldsEmpty([username, password])) {
      alert("Username and password cannot be empty.");
      return false; // Stop form submission
    }
    alert("Login successful!");
    return true; // Allow form submission
  }
  