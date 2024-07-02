document.addEventListener('DOMContentLoaded', function() {
    // Example: Add event listener to all product cards
    const productCards = document.querySelectorAll('.product');
    productCards.forEach(card => {
        card.addEventListener('click', function() {
            alert('Product clicked: ' + this.querySelector('h3').innerText);
        });
    });

    // Example: AJAX request to fetch more products
    document.getElementById('loadMore').addEventListener('click', function() {
        const pageNum = parseInt(this.dataset.pageNum) + 1;
        const pageSize = 8; // Adjust as needed

        fetch(`http://merchantapi.vtrustcard.com/api/v1/getGoodsList/${pageNum}/${pageSize}`)
            .then(response => response.json())
            .then(data => {
                if (data && data.data) {
                    // Append new products to the product list
                    const productList = document.querySelector('.products');
                    data.data.forEach(product => {
                        const productCard = document.createElement('div');
                        productCard.className = 'product';
                        productCard.innerHTML = `
                            <h3>${product.goodsName}</h3>
                            <ul>
                                <li>ID: ${product.id}</li>
                                <li>Pay Price: ${product.payPrice}</li>
                                <li>Cost Currency: ${product.costCurrency}</li>
                            </ul>
                        `;
                        productList.appendChild(productCard);
                    });
                    this.dataset.pageNum = pageNum;
                } else {
                    alert('No more products found.');
                }
            })
            .catch(error => console.error('Error fetching products:', error));
    });
});

