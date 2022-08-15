/* document.addEventListener('keydown', function (e) {
    let container = document.getElementById('search_results');
    console.log(container)
    if (!container.contains(e.target)) {
        container.style.display = 'none';
        hide_results();
        document.querySelector("input.search-input").value = "";
    }
}); */

let clearInputButton = document.querySelector("i.clear-input")
// People prof. exp. use this approach
let search_timer // used to stop the search_timer
function search() {
    let lol = document.querySelector("#search-form");
    if (search_timer) {
        clearTimeout(search_timer)
    }
    if (event.target.value.length >= 2) {
        search_timer = setTimeout(async function () {
            let conn = await fetch('/search', {
                method: "POST",
                body: new FormData(document.querySelector("#search-form"))
            })
            if (!conn.ok) {
                console.log('Could not connect to database');
            }
            let products = await conn.json()
            // populate the results
            document.querySelector("#search_results").innerHTML = ""
            let resultDiv = document.querySelector(".search-result-amount");
            resultDiv.textContent = products.length + " Results";



            products.forEach(product => {

                console.log(product.product_id);
                let image = JSON.parse(product.product_image)
                console.log(image);
                let single_product = `
                
 
                 
                 <div class="product">
                 <div class="img-container">
                     <img src="/product-images/${image[0]}" alt="Image of ${product.product_title}">
                 </div>
                 <div class="product-info">
                     <div class="product-info-top">
                         <div class="title"> ${product.product_title}</div>
                         <div class="price"> ${product.product_price} <span>Dkk</span></div>
                     </div>
            
                 </div>
                 <a href="/single-product/${product.product_id}"></a>
             </div>
                 
                 
                 
                 `
                document.querySelector("#search_results").insertAdjacentHTML('beforeend', single_product)
            })

            clearInputButton.style.display = "inline-flex"
            show_results()
        }, 200)
    } else {
        hide_results()
    }
}

function show_results() {
    let searchForm = document.querySelector('.search-input')
    let newestProducts = document.getElementById("newest-products")
    /*    console.log(event.target.value, "lol") */
    if (searchForm.value.length >= 2) {
        let search_results = document.querySelector("#search_results")
        let product_container = document.querySelector(".product-container")
        console.log("show results ", search_results, product_container)
        search_results.style.display = "grid"
        product_container.style.display = "none"
        newestProducts.style.display = "none";
        // display search_results div
        // populate/render the individual results
    }
}

function hide_results() {
    // hide search_results div
    let search_results = document.querySelector("#search_results")
    let product_container = document.querySelector(".product-container")
    let newestProducts = document.getElementById("newest-products")
    let resultDiv = document.querySelector(".search-result-amount");
    resultDiv.textContent = "All products";
    console.log("hide results ", search_results, product_container)
    search_results.style.display = "none"
    product_container.style.display = "grid"
    newestProducts.style.display = "grid";

}

function clear_input() {
    hide_results();
    document.querySelector("input.search-input").value = "";
    clearInputButton.style.display = "none"

}