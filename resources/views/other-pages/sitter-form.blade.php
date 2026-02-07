<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Apply as a Pet Sitter | Pet Haven</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/components/header.css') }}">
  <link rel="stylesheet" href="{{ asset('css/other-pages/adoption-form.css') }}">
  <link rel="stylesheet" href="{{ asset('css/other-pages/user-options.css') }}">
</head>
<body>

  <main>
    <section class="intro">
      <h1>Apply as a Pet Sitter</h1>
      <p>
        Thank you for your interest in taking care of pets.  
        Please fill out this form to apply as a pet sitter — our team will review your application and contact you within 1–2 days.
      </p>
    </section>
     
    <section class="form-container">
      <form id="mainForm" action="{{ route('store-pet-sitter') }}" method="POST">
        @csrf

        <div class="form-group">
          <label for="wilaya">Wilaya  </label>
          <select id="wilaya" name="wilaya" required>
           <option value="">-- Choose wilaya --</option>
<option value="01">01 – Adrar</option>
<option value="02">02 – Chlef</option>
<option value="03">03 – Laghouat</option>
<option value="04">04 – Oum El Bouaghi</option>
<option value="05">05 – Batna</option>
<option value="06">06 – Béjaïa</option>
<option value="07">07 – Biskra</option>
<option value="08">08 – Béchar</option>
<option value="09">09 – Blida</option>
<option value="10">10 – Bouira</option>
<option value="11">11 – Tamanrasset</option>
<option value="12">12 – Tébessa</option>
<option value="13">13 – Tlemcen</option>
<option value="14">14 – Tiaret</option>
<option value="15">15 – Tizi Ouzou</option>
<option value="16">16 – Alger</option>
<option value="17">17 – Djelfa</option>
<option value="18">18 – Jijel</option>
<option value="19">19 – Sétif</option>
<option value="20">20 – Saïda</option>
<option value="21">21 – Skikda</option>
<option value="22">22 – Sidi Bel Abbès</option>
<option value="23">23 – Annaba</option>
<option value="24">24 – Guelma</option>
<option value="25">25 – Constantine</option>
<option value="26">26 – Médéa</option>
<option value="27">27 – Mostaganem</option>
<option value="28">28 – M'Sila</option>
<option value="29">29 – Mascara</option>
<option value="30">30 – Ouargla</option>
<option value="31">31 – Oran</option>
<option value="32">32 – El Bayadh</option>
<option value="33">33 – Illizi</option>
<option value="34">34 – Bordj Bou Arréridj</option>
<option value="35">35 – Boumerdès</option>
<option value="36">36 – El Tarf</option>
<option value="37">37 – Tindouf</option>
<option value="38">38 – Tissemsilt</option>
<option value="39">39 – El Oued</option>
<option value="40">40 – Khenchela</option>
<option value="41">41 – Souk Ahras</option>
<option value="42">42 – Tipaza</option>
<option value="43">43 – Mila</option>
<option value="44">44 – Aïn Defla</option>
<option value="45">45 – Naâma</option>
<option value="46">46 – Aïn Témouchent</option>
<option value="47">47 – Ghardaïa</option>
<option value="48">48 – Relizane</option>
<option value="49">49 – Timimoun</option>
<option value="50">50 – Bordj Badji Mokhtar</option>
<option value="51">51 – Ouled Djellal</option>
<option value="52">52 – Béni Abbès</option>
<option value="53">53 – In Salah</option>
<option value="54">54 – In Guezzam</option>
<option value="55">55 – Touggourt</option>
<option value="56">56 – Djanet</option>
<option value="57">57 – El M'Ghair</option>
<option value="58">58 – El Meniaa</option>
<option value="59">59 – Aflou</option>
<option value="60">60 – El Abiodh Sidi Cheikh</option>
<option value="61">61 – El Aricha</option>
<option value="62">62 – El Kantara</option>
<option value="63">63 – Barika</option>
<option value="64">64 – Bou Saâda</option>
<option value="65">65 – Bir El Ater</option>
<option value="66">66 – Ksar El Boukhari</option>
<option value="67">67 – Ksar Chellala</option>
<option value="68">68 – Aïn Oussara</option>
<option value="69">69 – Messaâd</option>
          </select>
          <span class="error" id="wilayaError"></span>
        </div>

        <div class="form-group">
          <label for="description">About You / Experience </label>
          <textarea 
            id="description" 
            name="description" 
            placeholder="Describe your experience with pets, availability, skills, and anything else..." 
            rows="6" 
            maxlength="500"
            required
          ></textarea>
          <small class="char-count">0 / 500 characters</small>
          <span class="error" id="descriptionError"></span>
        </div>

        <div class="form-group">
          <label for="hourlyPay">Expected Hourly Pay (DZD)</label>
          <input 
            type="number" 
            id="hourlyPay" 
            name="hourlyPay" 
            placeholder="e.g., 200" 
            min="0" 
            step="0.01" 
            required
          >
          <span class="error" id="hourlyPayError"></span>
        </div>

        <button type="submit" class="submit-btn">Submit Application</button>
      </form>
    </section>
  </main>

  @include('partials.header')
  <script src="{{ asset('js/other-scripts/sitter-form.js') }}"></script>

</body>
</html>
