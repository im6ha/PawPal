// ================ FILTER CREATORS ================

export function createPetFilter() {
  const container = document.createElement('div');
  container.className = 'filter';
  container.innerHTML = `
    <button class="filter-btn" id="pet-filter">
      <span class="btn-label">Pet Type</span>
      <span class="arrow">▼</span>
    </button>
    <div class="dropdown" id="pet-dropdown">
      <label><input type="checkbox" value="Dog" /> Dog</label>
      <label><input type="checkbox" value="Cat" /> Cat</label>
      <label><input type="checkbox" value="Bird" /> Bird</label>
      <label><input type="checkbox" value="Rabbit" /> Rabbit</label>
      <label><input type="checkbox" value="Fish" /> Fish</label>
      <label><input type="checkbox" value="Hamster" /> Hamster</label>
      <label><input type="checkbox" value="Other Pets" /> Other Pets</label>
    </div>
  `;
  return container;
}

export function createLocationFilter() {
  const container = document.createElement('div');
  container.className = 'filter';
  container.innerHTML = `
    <button class="filter-btn" id="wilaya-filter">
      <span class="btn-label">Location</span>
      <span class="arrow">▼</span>
    </button>
    <div class="dropdown scrollable" id="wilaya-dropdown">
      <label><input type="checkbox" value="01" /> 01 - Adrar</label>
      <label><input type="checkbox" value="02" /> 02 – Chlef</label>
      <label><input type="checkbox" value="03" /> 03 – Laghouat</label>
      <label><input type="checkbox" value="04" /> 04 – Oum El Bouaghi</label>
      <label><input type="checkbox" value="05" /> 05 – Batna</label>
      <label><input type="checkbox" value="06" /> 06 – Béjaïa</label>
      <label><input type="checkbox" value="07" /> 07 – Biskra</label>
      <label><input type="checkbox" value="08" /> 08 – Béchar</label>
      <label><input type="checkbox" value="09" /> 09 – Blida</label>
      <label><input type="checkbox" value="10" /> 10 – Bouïra</label>
      <label><input type="checkbox" value="11" /> 11 – Tamanrasset</label>
      <label><input type="checkbox" value="12" /> 12 – Tébessa</label>
      <label><input type="checkbox" value="13" /> 13 – Tlemcen</label>
      <label><input type="checkbox" value="14" /> 14 – Tiaret</label>
      <label><input type="checkbox" value="15" /> 15 – Tizi Ouzou</label>
      <label><input type="checkbox" value="16" /> 16 – Alger</label>
      <label><input type="checkbox" value="17" /> 17 – Djelfa</label>
      <label><input type="checkbox" value="18" /> 18 – Jijel</label>
      <label><input type="checkbox" value="19" /> 19 – Sétif</label>
      <label><input type="checkbox" value="20" /> 20 – Saïda</label>
      <label><input type="checkbox" value="21" /> 21 – Skikda</label>
      <label><input type="checkbox" value="22" /> 22 – Sidi Bel Abbès</label>
      <label><input type="checkbox" value="23" /> 23 – Annaba</label>
      <label><input type="checkbox" value="24" /> 24 – Guelma</label>
      <label><input type="checkbox" value="25" /> 25 – Constantine</label>
      <label><input type="checkbox" value="26" /> 26 – Médéa</label>
      <label><input type="checkbox" value="27" /> 27 – Mostaganem</label>
      <label><input type="checkbox" value="28" /> 28 – M’Sila</label>
      <label><input type="checkbox" value="29" /> 29 – Mascara</label>
      <label><input type="checkbox" value="30" /> 30 – Ouargla</label>
      <label><input type="checkbox" value="31" /> 31 – Oran</label>
      <label><input type="checkbox" value="32" /> 32 – El Bayadh</label>
      <label><input type="checkbox" value="33" /> 33 – Illizi</label>
      <label><input type="checkbox" value="34" /> 34 – Bordj Bou Arréridj</label>
      <label><input type="checkbox" value="35" /> 35 – Boumerdès</label>
      <label><input type="checkbox" value="36" /> 36 – El Tarf</label>
      <label><input type="checkbox" value="37" /> 37 – Tindouf</label>
      <label><input type="checkbox" value="38" /> 38 – Tissemsilt</label>
      <label><input type="checkbox" value="39" /> 39 – El Oued</label>
      <label><input type="checkbox" value="40" /> 40 – Khenchela</label>
      <label><input type="checkbox" value="41" /> 41 – Souk Ahras</label>
      <label><input type="checkbox" value="42" /> 42 – Tipaza</label>
      <label><input type="checkbox" value="43" /> 43 – Mila</label>
      <label><input type="checkbox" value="44" /> 44 – Aïn Defla</label>
      <label><input type="checkbox" value="45" /> 45 – Naâma</label>
      <label><input type="checkbox" value="46" /> 46 – Aïn Témouchent</label>
      <label><input type="checkbox" value="47" /> 47 – Ghardaïa</label>
      <label><input type="checkbox" value="48" /> 48 – Relizane</label>
      <label><input type="checkbox" value="49" /> 49 – Timimoun</label>
      <label><input type="checkbox" value="50" /> 50 – Bordj Badji Mokhtar</label>
      <label><input type="checkbox" value="51" /> 51 – Ouled Djellal</label>
      <label><input type="checkbox" value="52" /> 52 – Béni Abbès</label>
      <label><input type="checkbox" value="53" /> 53 – In Salah</label>
      <label><input type="checkbox" value="54" /> 54 – In Guezzam</label>
      <label><input type="checkbox" value="55" /> 55 – Touggourt</label>
      <label><input type="checkbox" value="56" /> 56 – Djanet</label>
      <label><input type="checkbox" value="57" /> 57 – El M’Ghair</label>
      <label><input type="checkbox" value="58" /> 58 – El Menia</label>
      <label><input type="checkbox" value="59" /> 59 – Aflou</label>
      <label><input type="checkbox" value="60" /> 60 – El Abiodh Sidi Cheikh</label>
      <label><input type="checkbox" value="61" /> 61 – El Aricha</label>
      <label><input type="checkbox" value="62" /> 62 – El Kantara</label>
      <label><input type="checkbox" value="63" /> 63 – Barika</label>
      <label><input type="checkbox" value="64" /> 64 – Bou Saâda</label>
      <label><input type="checkbox" value="65" /> 65 – Bir El Ater</label>
      <label><input type="checkbox" value="66" /> 66 – Ksar El Boukhari</label>
      <label><input type="checkbox" value="67" /> 67 – Ksar Chellala</label>
      <label><input type="checkbox" value="68" /> 68 – Aïn Oussara</label>
      <label><input type="checkbox" value="69" /> 69 – Messaâd</label>
    </div>
  `;
  return container;
}

export function createGenderFilter() {
  const container = document.createElement('div');
  container.className = 'filter';
  container.innerHTML = `
    <button class="filter-btn" id="gender-filter">
      <span class="btn-label">Gender</span>
      <span class="arrow">▼</span>
    </button>
    <div class="dropdown" id="gender-dropdown">
      <label><input type="checkbox" value="Male" /> Male</label>
      <label><input type="checkbox" value="Female" /> Female</label> 
    </div>
  `;
  return container;
}

export function createCategoryFilter() {
  const container = document.createElement('div');
  container.className = 'filter';
  container.innerHTML = `
    <button class="filter-btn" id="category-filter">
      <span class="btn-label">Category</span>
      <span class="arrow">▼</span>
    </button>
    <div class="dropdown" id="category-dropdown">
      <label><input type="checkbox" value="Food" /> Food</label>
      <label><input type="checkbox" value="Toys" /> Toys</label>
      <label><input type="checkbox" value="Beds" /> Beds</label>
      <label><input type="checkbox" value="Clothing" /> Clothing</label>
      <label><input type="checkbox" value="Accessories" /> Accessories</label>
      <label><input type="checkbox" value="Other" /> Other</label>
    </div>
  `;
  return container;
}

export function createStatusFilter() {
  const container = document.createElement('div');
  container.className = 'filter';
  container.innerHTML = `
    <button class="filter-btn" id="status-filter">
      <span class="btn-label">Status</span>
      <span class="arrow">▼</span>
    </button>
    <div class="dropdown" id="status-dropdown">
      <label><input type="checkbox" value="Lost" /> Lost</label>
      <label><input type="checkbox" value="Found" /> Found</label>
    </div>
  `;
  return container;
}

export function createPriceFilter() {
  const container = document.createElement('div');
  container.className = 'filter';
  container.innerHTML = `
 <button class="filter-btn2"> Price Range </button>
                            <div class="filter-dropdown2" id="filterDropdown2">
                                <div class="price-option">
                                    <label for="start" id="startp">From : </label>
                                    <input type="number" id="start" value="option1">
                                </div>
                                <div class="price-option">
                                    <label for="end" id="endp">To :</label>
                                    <input type="number" id="end" value="option1">
                                </div>
                            </div>

  `;
  return container;
}

// ================ SHARED BEHAVIOR ================

export function setupFilterBehavior() {

  const allDropdowns = () => document.querySelectorAll(".dropdown");
  const allArrows = () => document.querySelectorAll(".arrow");

  function closeAll() {
    allDropdowns().forEach(d => d.classList.remove("show"));
    allArrows().forEach(a => a.classList.remove("active"));
  }

  document.addEventListener("click", (e) => {
    const btn = e.target.closest(".filter-btn");
    const dropdown = e.target.closest(".dropdown");

    if (dropdown) {
      e.stopPropagation();
      return;
    }

    if (btn) {
      e.stopPropagation();

      const dropdownId = btn.id.replace("-filter", "-dropdown");
      const targetDropdown = document.getElementById(dropdownId);
      const arrow = btn.querySelector(".arrow");

      const isOpen = targetDropdown.classList.contains("show");

      closeAll(); 

      if (!isOpen) {
        targetDropdown.classList.add("show");
        arrow.classList.add("active");
      }

      return;
    }

    closeAll();
  });
}
