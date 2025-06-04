function toggleFiltersMenuAside(){
    const button = document.getElementById("sidebar_logo");
    var aside = document.getElementById("menu");
    button.addEventListener('click', function(){
        aside.classList.toggle("hidden");
        
    })
    
}



function chooseFiltersMenu(){

    const boxes = document.querySelectorAll('div span+input[type="checkbox"]')
    for (const box of boxes){
        box.addEventListener('click', function() {
            var filter = box.previousElementSibling
            if (box.parentElement.classList.contains("price_filter")){
                var marked_price = document.getElementById("marked")
               
                if (marked_price !== null) {
                    marked_price.removeAttribute('id')
                    var price_checkbox = marked_price.nextElementSibling
                    price_checkbox.checked = false;

                }
                if (filter !== marked_price || marked_price === null){
                    filter.id = "marked"
                }
                
            }
            else {
                filter.classList.toggle("unmarked")
                filter.classList.toggle("marked")
            }
            
           
            
        })
    }
    

}

function submitFiltersMenu(){
    const submitButton = document.getElementById("submit")
    submitButton.addEventListener('click', function(event) {
        
        event.preventDefault()
        const selected_genres = document.querySelectorAll('aside#menu>div.genre_filter span.marked')
        const genres = []
        if (selected_genres != null){
            for (const genre of selected_genres){
                let genre_content = genre.textContent
                genres.push(genre_content)
                
            }
        }

        genres.forEach(element => {
            console.log(element)
            
        })

        const selected_devices = document.querySelectorAll('aside#menu>div.device_filter span.marked')
        const devices = []
        if (selected_devices != null){
            for (const device of selected_devices){
                let device_content = device.textContent
                devices.push(device_content)
            }
        }
        devices.forEach(element => {
            console.log(element)
            
        })

        var price = 10000
        const selected_max_price = document.querySelector('aside#menu>div.price_filter span#marked')
        if (selected_max_price != null){
            price = Number(selected_max_price.textContent)
        }


        
        const developers = []

        $.ajax({
            url: 'FilterResults.php',
            type: 'GET',
            data: {
                price: price,
                genres: genres,
                devices: devices,
                developers: developers 
            },
            success: function(response) {
                console.log(response);
                window.location.href = 'FilterResults.php?' + $.param({
                    price: price,
                    genres: genres,
                    devices: devices,
                    developers: developers 
                });
    
               
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log("ERROR");
            }
        });
       
    })
    
}

toggleFiltersMenuAside()
chooseFiltersMenu()
submitFiltersMenu()
