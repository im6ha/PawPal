<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/other-pages/report-lost.css') }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet" />

    <title>Report Lost Pet | Pet Care</title>
</head>

<body>

    <div class="logo">
        <a href="{{ route('home') }}"><img src="{{ asset('media/images/logo.png') }}" alt="Logo"></a>
    </div>

    <div class="container">
        <header>
            <h1>Report Lost Pet</h1>
            <p>Help us reunite pets with their families</p>
        </header>

        <div class="form-container">
            <form id="lostPetForm" action="{{ route('report-lost.store') }}" method="POST"
                enctype="multipart/form-data"> @csrf
                <div class="form-group">
                    <div class="form-group">
                        <label for="petType">Pet Type <span class="required">*</span></label>
                        <select id="petType" name="petType">
                            <option value="">Select pet type</option>
                            <option value="dog">Dog</option>
                            <option value="cat">Cat</option>
                            <option value="bird">Bird</option>
                            <option value="rabbit">Rabbit</option>
                            <option value="hamster">Hamster</option>
                            <option value="fish">Fish</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">

                        
                    <div class="form-row">
                        <div class="form-group">
                            <label for="wilaya">Wilaya <span class="required">*</span></label>
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
                            <div class="error-message" id="wilaya-error">Please select wilaya</div>
                        </div>
                        <div class="form-group">
                            <label for="lastSeen">Last Seen Area <span class="required">*</span></label>
                            <input type="text" id="lastSeen" name="lastSeen"
                                placeholder="Enter the specific area/place" required>
                            <div class="error-message" id="lastSeen-error">Please enter last seen area</div>
                        </div>
                    </div>
                </div>



                <div class="form-group">
                    <label for="description">Describe this lost pet <span class="required">*</span></label>
                    <textarea id="description" name="description" rows="4"
                        placeholder="Describe all the details of this pet including its color, size, and Any additional information"
                        required></textarea>
                </div>

                <div class="form-group">
                    <label>Upload Photo</label>
                    <div class="photo-upload">
                        <i>📷</i>
                        <p>Click to upload a photo of your pet</p>
                        <p class="small">JPG, PNG or GIF (max 5MB)</p>
                        <input type="file" id="petPhoto" name="petPhoto" accept="image/*">
                    </div>
                </div>




                <button type="submit" class="btn">Submit Lost Pet Report</button>

                <div class="form-footer">
                    <p>Your information will be kept private and used only to help reunite you with your pet.</p>
                </div>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/other-scripts/report-lost.js') }}"></script>

</body>

</html>
