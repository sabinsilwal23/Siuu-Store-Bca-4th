document.addEventListener('DOMContentLoaded', () => {
    
    document.getElementById('productsButton').addEventListener('click', () => {
        window.location.href = "products.php";
    });

    
    const forms = document.querySelectorAll('.add-to-cart-form');
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            console.log('Form submitted');
            const formData = new FormData(form);
            fetch('products.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log('Response received:', data); 
                if (data.message) {
                    const messageDiv = document.getElementById('message');
                    messageDiv.innerText = data.message;
                    messageDiv.style.color = 'green';
                    messageDiv.style.display = 'block';

                   
                    window.location.href = 'cart.php';
                } else {
                    console.error('Error:', data);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
});