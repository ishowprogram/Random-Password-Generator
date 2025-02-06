    function generatePassword() {
        const uppercase = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        const lowercase = "abcdefghijklmnopqrstuvwxyz";
        const numbers = "0123456789";
        const symbols = "!@#$%^&*()_+~`|}{[]:;?><,./-=";

        let characters = "";
        if (document.getElementById("uppercase").checked) characters += uppercase;
        if (document.getElementById("numbers").checked) characters += numbers;
        if (document.getElementById("lowercase").checked) characters += lowercase;
        if (document.getElementById("symbols").checked) characters += symbols;

        let password = "";
        const length = document.getElementById("passwordLength").value;

        for (let i = 0; i < length; i++) {
            password += characters.charAt(Math.floor(Math.random() * characters.length));
        }

        document.getElementById("password").value = password;
    }

    function copyToClipboard() {
        const passwordField = document.getElementById("password");
        passwordField.select();
        document.execCommand("copy");
        alert("Password copied to clipboard!");
    }

    document.getElementById("generate").addEventListener("click", generatePassword);
    document.getElementById("copy").addEventListener("click", copyToClipboard);

    const passwordLengthSlider = document.getElementById('passwordLength');
    const lengthValueSpan = document.getElementById('lengthValue');

    passwordLengthSlider.addEventListener('input', function() {
        lengthValueSpan.textContent = this.value;
    });