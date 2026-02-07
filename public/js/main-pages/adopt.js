import { createPetFilter, createLocationFilter, createGenderFilter, setupFilterBehavior } from "../components/filters.js";


document.addEventListener("DOMContentLoaded", () => {

document.getElementById("filter-pet").appendChild(createPetFilter());
document.getElementById("filter-location").appendChild(createLocationFilter());
document.getElementById("filter-gender").appendChild(createGenderFilter());
setupFilterBehavior();

})