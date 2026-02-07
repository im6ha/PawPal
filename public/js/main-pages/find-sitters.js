import { createPetFilter, createLocationFilter, createPriceFilter, setupFilterBehavior } from "../components/filters.js";
import { createServiceCard } from "../components/cards.js";




document.addEventListener("DOMContentLoaded", () => {

document.getElementById("filter-pet").appendChild(createPetFilter());
document.getElementById("filter-location").appendChild(createLocationFilter());
document.getElementById("filter-price").appendChild(createPriceFilter());
setupFilterBehavior();

})




document.addEventListener("DOMContentLoaded", async () => {
    let sittersGrid = document.getElementById("sitters-grid");

    const response = await fetch("/sitters-data");
    const sitters = await response.json();

    sitters.forEach(sitter => {
        sittersGrid.appendChild(createServiceCard(
            sitter.user.User_fname,
            sitter.wilaya,
            sitter.description,
            sitter.hourly_pay
        ));
    });
});
