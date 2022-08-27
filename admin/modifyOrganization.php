<?php
session_start();
require "../functions.php";

if ($_SESSION['sid'] != 1){
  redirect("../denied.php");
}

$connect = connectDB();

$adresseElectronique = $_POST['modifyO'];
$q = "SELECT * FROM organization WHERE mail = '$adresseElectronique'";
$res = $connect->query($q);
$data = $res->fetch();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    Modification Association
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.0.4" rel="stylesheet" />
</head>

<body class="g-sidenav-show  bg-gray-200">
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="" target="_blank">
        <img src="../assets/img/logo-ct.png" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold text-white">No More Waste</span>
      </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link text-white " href="dashboard.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">dashboard</i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white " href="particuliers.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">person</i>
            </div>
            <span class="nav-link-text ms-1">Particuliers</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white " href="commerces.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">receipt_long</i>
            </div>
            <span class="nav-link-text ms-1">Commerces</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white active bg-gradient-primary" href="associations.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">assignment</i>
            </div>
            <span class="nav-link-text ms-1">Associations</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white " href="paniers.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">weekend</i>
            </div>
            <span class="nav-link-text ms-1">Paniers</span>
          </a>
        </li>
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Compte</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white " href="profile.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">person</i>
            </div>
            <span class="nav-link-text ms-1">Profil</span>
          </a>
        </li>
      </ul>
    </div>
    <div class="sidenav-footer position-absolute w-100 bottom-0 ">
      <div class="mx-3">
        <a class="btn bg-gradient-primary mt-4 w-100" href="../logout.php" type="button">Déconnexion</a>
      </div>
    </div>
  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Admin</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Associations</li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Modification Association</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">Modification Association</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <div class="input-group input-group-outline">
              <label class="form-label">Ecrivez ici...</label>
              <input type="text" class="form-control">
            </div>
          </div>

        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <form class="form-register" action="modifyOrganizationBack.php" method="post">
        <div class="col-12 col-xl-4">
          <div class="card card-plain h-100">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-md-8 d-flex align-items-center">
                  <h6 class="mb-0">Modification Association</h6>
                </div>
              </div>                  
              <hr class="horizontal gray-light my-4">
              <ul class="list-group">
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Autorisation Inscription :</strong> &nbsp;
                  <div>
                    <input type="radio" name="autorisation" id="autorisee" value="autorisee">
                    <label for="autorisee">Valider</label>
                  </div>
                  <div>
                    <input type="radio" name="autorisation" id="refusee" value="refusee" >
                    <label for="refusee">Refuser</label>
                  </div>  
                </li>
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Nom de l'association:</strong> &nbsp;
                  <input type="text" name="organizationName" placeholder="Nom du commerce" value="<?=$data["nom"]?>" required>      
                </li>
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">SIREN:</strong> &nbsp;
                  <input type="text"  name="siren" placeholder="SIREN" value="<?=$data["siren"]?>" required>        
                </li>
                <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Année création:</strong> &nbsp;
                  <input type="text" name="creationYear" placeholder="Année création" value="<?=$data["annee_creation"]?>" required>        
                </li>
                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Téléphone:</strong> &nbsp; 
                  <input type="text" name="phone" placeholder="0612345789" value="<?=$data["numero_telephone"]?>" required>
                </li>
                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Email:</strong> &nbsp; 
                  <input type="text" name="email" placeholder="example@email.com" value="<?=$data["mail"]?>" required>
                </li>
                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Adresse:</strong> &nbsp; 
                  <input type="text" name="address" placeholder="123 rue emile" value="<?=$data["adresse"]?>" required>
                </li>
                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Code Postal:</strong> &nbsp; 
                  <input type="text" name="zip" placeholder="75012" value="<?=$data["code_postal"]?>" required>
                </li>
                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Ville:</strong> &nbsp; 
                  <input type="text" name="city" placeholder="Paris" value="<?=$data["ville"]?>" required>
                </li>
                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Pays:</strong> &nbsp; 
                  <select name="country">
      <option value="<?=$data["pays"]?>" selected="selected"><?=$data["pays"]?></option>

      <option value="Afghanistan">Afghanistan </option>
      <option value="Afrique_Centrale">Afrique_Centrale </option>
      <option value="Afrique_du_sud">Afrique_du_Sud </option>
      <option value="Albanie">Albanie </option>
      <option value="Algerie">Algerie </option>
      <option value="Allemagne">Allemagne </option>
      <option value="Andorre">Andorre </option>
      <option value="Angola">Angola </option>
      <option value="Anguilla">Anguilla </option>
      <option value="Arabie_Saoudite">Arabie_Saoudite </option>
      <option value="Argentine">Argentine </option>
      <option value="Armenie">Armenie </option>
      <option value="Australie">Australie </option>
      <option value="Autriche">Autriche </option>
      <option value="Azerbaidjan">Azerbaidjan </option>

      <option value="Bahamas">Bahamas </option>
      <option value="Bangladesh">Bangladesh </option>
      <option value="Barbade">Barbade </option>
      <option value="Bahrein">Bahrein </option>
      <option value="Belgique">Belgique </option>
      <option value="Belize">Belize </option>
      <option value="Benin">Benin </option>
      <option value="Bermudes">Bermudes </option>
      <option value="Bielorussie">Bielorussie </option>
      <option value="Bolivie">Bolivie </option>
      <option value="Botswana">Botswana </option>
      <option value="Bhoutan">Bhoutan </option>
      <option value="Boznie_Herzegovine">Boznie_Herzegovine </option>
      <option value="Bresil">Bresil </option>
      <option value="Brunei">Brunei </option>
      <option value="Bulgarie">Bulgarie </option>
      <option value="Burkina_Faso">Burkina_Faso </option>
      <option value="Burundi">Burundi </option>

      <option value="Caiman">Caiman </option>
      <option value="Cambodge">Cambodge </option>
      <option value="Cameroun">Cameroun </option>
      <option value="Canada">Canada </option>
      <option value="Canaries">Canaries </option>
      <option value="Cap_vert">Cap_Vert </option>
      <option value="Chili">Chili </option>
      <option value="Chine">Chine </option>
      <option value="Chypre">Chypre </option>
      <option value="Colombie">Colombie </option>
      <option value="Comores">Colombie </option>
      <option value="Congo">Congo </option>
      <option value="Congo_democratique">Congo_democratique </option>
      <option value="Cook">Cook </option>
      <option value="Coree_du_Nord">Coree_du_Nord </option>
      <option value="Coree_du_Sud">Coree_du_Sud </option>
      <option value="Costa_Rica">Costa_Rica </option>
      <option value="Cote_d_Ivoire">Côte_d_Ivoire </option>
      <option value="Croatie">Croatie </option>
      <option value="Cuba">Cuba </option>

      <option value="Danemark">Danemark </option>
      <option value="Djibouti">Djibouti </option>
      <option value="Dominique">Dominique </option>

      <option value="Egypte">Egypte </option>
      <option value="Emirats_Arabes_Unis">Emirats_Arabes_Unis </option>
      <option value="Equateur">Equateur </option>
      <option value="Erythree">Erythree </option>
      <option value="Espagne">Espagne </option>
      <option value="Estonie">Estonie </option>
      <option value="Etats_Unis">Etats_Unis </option>
      <option value="Ethiopie">Ethiopie </option>

      <option value="Falkland">Falkland </option>
      <option value="Feroe">Feroe </option>
      <option value="Fidji">Fidji </option>
      <option value="Finlande">Finlande </option>
      <option value="France">France </option>

      <option value="Gabon">Gabon </option>
      <option value="Gambie">Gambie </option>
      <option value="Georgie">Georgie </option>
      <option value="Ghana">Ghana </option>
      <option value="Gibraltar">Gibraltar </option>
      <option value="Grece">Grece </option>
      <option value="Grenade">Grenade </option>
      <option value="Groenland">Groenland </option>
      <option value="Guadeloupe">Guadeloupe </option>
      <option value="Guam">Guam </option>
      <option value="Guatemala">Guatemala</option>
      <option value="Guernesey">Guernesey </option>
      <option value="Guinee">Guinee </option>
      <option value="Guinee_Bissau">Guinee_Bissau </option>
      <option value="Guinee equatoriale">Guinee_Equatoriale </option>
      <option value="Guyana">Guyana </option>
      <option value="Guyane_Francaise ">Guyane_Francaise </option>

      <option value="Haiti">Haiti </option>
      <option value="Hawaii">Hawaii </option>
      <option value="Honduras">Honduras </option>
      <option value="Hong_Kong">Hong_Kong </option>
      <option value="Hongrie">Hongrie </option>

      <option value="Inde">Inde </option>
      <option value="Indonesie">Indonesie </option>
      <option value="Iran">Iran </option>
      <option value="Iraq">Iraq </option>
      <option value="Irlande">Irlande </option>
      <option value="Islande">Islande </option>
      <option value="Israel">Israel </option>
      <option value="Italie">italie </option>

      <option value="Jamaique">Jamaique </option>
      <option value="Jan Mayen">Jan Mayen </option>
      <option value="Japon">Japon </option>
      <option value="Jersey">Jersey </option>
      <option value="Jordanie">Jordanie </option>

      <option value="Kazakhstan">Kazakhstan </option>
      <option value="Kenya">Kenya </option>
      <option value="Kirghizstan">Kirghizistan </option>
      <option value="Kiribati">Kiribati </option>
      <option value="Koweit">Koweit </option>

      <option value="Laos">Laos </option>
      <option value="Lesotho">Lesotho </option>
      <option value="Lettonie">Lettonie </option>
      <option value="Liban">Liban </option>
      <option value="Liberia">Liberia </option>
      <option value="Liechtenstein">Liechtenstein </option>
      <option value="Lituanie">Lituanie </option>
      <option value="Luxembourg">Luxembourg </option>
      <option value="Lybie">Lybie </option>

      <option value="Macao">Macao </option>
      <option value="Macedoine">Macedoine </option>
      <option value="Madagascar">Madagascar </option>
      <option value="Madère">Madère </option>
      <option value="Malaisie">Malaisie </option>
      <option value="Malawi">Malawi </option>
      <option value="Maldives">Maldives </option>
      <option value="Mali">Mali </option>
      <option value="Malte">Malte </option>
      <option value="Man">Man </option>
      <option value="Mariannes du Nord">Mariannes du Nord </option>
      <option value="Maroc">Maroc </option>
      <option value="Marshall">Marshall </option>
      <option value="Martinique">Martinique </option>
      <option value="Maurice">Maurice </option>
      <option value="Mauritanie">Mauritanie </option>
      <option value="Mayotte">Mayotte </option>
      <option value="Mexique">Mexique </option>
      <option value="Micronesie">Micronesie </option>
      <option value="Midway">Midway </option>
      <option value="Moldavie">Moldavie </option>
      <option value="Monaco">Monaco </option>
      <option value="Mongolie">Mongolie </option>
      <option value="Montserrat">Montserrat </option>
      <option value="Mozambique">Mozambique </option>

      <option value="Namibie">Namibie </option>
      <option value="Nauru">Nauru </option>
      <option value="Nepal">Nepal </option>
      <option value="Nicaragua">Nicaragua </option>
      <option value="Niger">Niger </option>
      <option value="Nigeria">Nigeria </option>
      <option value="Niue">Niue </option>
      <option value="Norfolk">Norfolk </option>
      <option value="Norvege">Norvege </option>
      <option value="Nouvelle_Caledonie">Nouvelle_Caledonie </option>
      <option value="Nouvelle_Zelande">Nouvelle_Zelande </option>

      <option value="Oman">Oman </option>
      <option value="Ouganda">Ouganda </option>
      <option value="Ouzbekistan">Ouzbekistan </option>

      <option value="Pakistan">Pakistan </option>
      <option value="Palau">Palau </option>
      <option value="Palestine">Palestine </option>
      <option value="Panama">Panama </option>
      <option value="Papouasie_Nouvelle_Guinee">Papouasie_Nouvelle_Guinee </option>
      <option value="Paraguay">Paraguay </option>
      <option value="Pays_Bas">Pays_Bas </option>
      <option value="Perou">Perou </option>
      <option value="Philippines">Philippines </option>
      <option value="Pologne">Pologne </option>
      <option value="Polynesie">Polynesie </option>
      <option value="Porto_Rico">Porto_Rico </option>
      <option value="Portugal">Portugal </option>

      <option value="Qatar">Qatar </option>

      <option value="Republique_Dominicaine">Republique_Dominicaine </option>
      <option value="Republique_Tcheque">Republique_Tcheque </option>
      <option value="Reunion">Reunion </option>
      <option value="Roumanie">Roumanie </option>
      <option value="Royaume_Uni">Royaume_Uni </option>
      <option value="Russie">Russie </option>
      <option value="Rwanda">Rwanda </option>

      <option value="Sahara Occidental">Sahara Occidental </option>
      <option value="Sainte_Lucie">Sainte_Lucie </option>
      <option value="Saint_Marin">Saint_Marin </option>
      <option value="Salomon">Salomon </option>
      <option value="Salvador">Salvador </option>
      <option value="Samoa_Occidentales">Samoa_Occidentales</option>
      <option value="Samoa_Americaine">Samoa_Americaine </option>
      <option value="Sao_Tome_et_Principe">Sao_Tome_et_Principe </option>
      <option value="Senegal">Senegal </option>
      <option value="Seychelles">Seychelles </option>
      <option value="Sierra Leone">Sierra Leone </option>
      <option value="Singapour">Singapour </option>
      <option value="Slovaquie">Slovaquie </option>
      <option value="Slovenie">Slovenie</option>
      <option value="Somalie">Somalie </option>
      <option value="Soudan">Soudan </option>
      <option value="Sri_Lanka">Sri_Lanka </option>
      <option value="Suede">Suede </option>
      <option value="Suisse">Suisse </option>
      <option value="Surinam">Surinam </option>
      <option value="Swaziland">Swaziland </option>
      <option value="Syrie">Syrie </option>

      <option value="Tadjikistan">Tadjikistan </option>
      <option value="Taiwan">Taiwan </option>
      <option value="Tonga">Tonga </option>
      <option value="Tanzanie">Tanzanie </option>
      <option value="Tchad">Tchad </option>
      <option value="Thailande">Thailande </option>
      <option value="Tibet">Tibet </option>
      <option value="Timor_Oriental">Timor_Oriental </option>
      <option value="Togo">Togo </option>
      <option value="Trinite_et_Tobago">Trinite_et_Tobago </option>
      <option value="Tristan da cunha">Tristan de cuncha </option>
      <option value="Tunisie">Tunisie </option>
      <option value="Turkmenistan">Turmenistan </option>
      <option value="Turquie">Turquie </option>

      <option value="Ukraine">Ukraine </option>
      <option value="Uruguay">Uruguay </option>

      <option value="Vanuatu">Vanuatu </option>
      <option value="Vatican">Vatican </option>
      <option value="Venezuela">Venezuela </option>
      <option value="Vierges_Americaines">Vierges_Americaines </option>
      <option value="Vierges_Britanniques">Vierges_Britanniques </option>
      <option value="Vietnam">Vietnam </option>

      <option value="Wake">Wake </option>
      <option value="Wallis et Futuma">Wallis et Futuma </option>

      <option value="Yemen">Yemen </option>
      <option value="Yougoslavie">Yougoslavie </option>

      <option value="Zambie">Zambie </option>
      <option value="Zimbabwe">Zimbabwe </option>

      </select>
                </li>
                <input type="submit" id="valider" value="Soumettre">
                <input type="hidden" name="modifyO" value="<?=$data["mail"]?>">
              </ul>
            </div>
          </div>
        </div>
      </form>
<?php

    if( !empty( $_COOKIE['errorForm'])){
?>
      <ul>
<?php
      $listOfErrors = unserialize($_COOKIE['errorForm']);
      foreach ($listOfErrors as $error) {
?>
        <li>
<?php
        echo ($error);      }
?>
      </ul>
<?php
      unset($listOfErrors);
    }

?>

      <footer class="footer py-4  ">
        <div class="container-fluid">
          <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
              <div class="copyright text-center text-sm text-muted text-lg-start">
                © <script>
                  document.write(new Date().getFullYear())
                </script>,
                made with <i class="fa fa-heart"></i> by
                <a href="" class="font-weight-bold" >Cheikh KANE.</a>
              </div>
            </div>
            <div class="col-lg-6">
              <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                <li class="nav-item">
                  <a href="" class="nav-link text-muted">Cheikh KANE</a>
                </li>
                <li class="nav-item">
                  <a href="" class="nav-link text-muted">About Us</a>
                </li>
                <li class="nav-item">
                  <a href="" class="nav-link text-muted">Blog</a>
                </li>
                <li class="nav-item">
                  <a href="" class="nav-link pe-0 text-muted">License</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </main>
  <div class="fixed-plugin">
    <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
      <i class="material-icons py-2">settings</i>
    </a>
    <div class="card shadow-lg">
      <div class="card-header pb-0 pt-3">
        <div class="float-start">
          <h5 class="mt-3 mb-0">Interface Personnalisée</h5>
          <p>Voir vos options dashboard.</p>
        </div>
        <div class="float-end mt-4">
          <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
            <i class="material-icons">claire</i>
          </button>
        </div>
        <!-- End Toggle Button -->
      </div>
      <hr class="horizontal dark my-1">
      <div class="card-body pt-sm-3 pt-0">
        <!-- Sidebar Backgrounds -->
        <div>
          <h6 class="mb-0">Coleurs barre latérale</h6>
        </div>
        <a href="javascript:void(0)" class="switch-trigger background-color">
          <div class="badge-colors my-2 text-start">
            <span class="badge filter bg-gradient-primary active" data-color="primary" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-dark" data-color="dark" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-info" data-color="info" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-success" data-color="success" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-warning" data-color="warning" onclick="sidebarColor(this)"></span>
            <span class="badge filter bg-gradient-danger" data-color="danger" onclick="sidebarColor(this)"></span>
          </div>
        </a>
        <!-- Sidenav Type -->
        <div class="mt-3">
          <h6 class="mb-0">Type de Sidenav</h6>
          <p class="text-sm">Choisir entre 2 differents types de sidenav.</p>
        </div>
        <div class="d-flex">
          <button class="btn bg-gradient-dark px-3 mb-2 active" data-class="bg-gradient-dark" onclick="sidebarType(this)">Dark</button>
          <button class="btn bg-gradient-dark px-3 mb-2 ms-2" data-class="bg-transparent" onclick="sidebarType(this)">Transparent</button>
          <button class="btn bg-gradient-dark px-3 mb-2 ms-2" data-class="bg-white" onclick="sidebarType(this)">White</button>
        </div>
        <p class="text-sm d-xl-none d-block mt-2">Vous pouvez changer le type de sidenav uniquement sur la vue de bureau.</p>
        <!-- Navbar Fixed -->
        <div class="mt-3 d-flex">
          <h6 class="mb-0">Barre de navigation fixe</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed" onclick="navbarFixed(this)">
          </div>
        </div>
        <hr class="horizontal dark my-3">
        <div class="mt-2 d-flex">
          <h6 class="mb-0">Light / Dark</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="dark-version" onclick="darkMode(this)">
          </div>
        </div>
        <hr class="horizontal dark my-sm-4">
        <a class="btn bg-gradient-info w-100" href="https://www.creative-tim.com/product/material-dashboard-pro">Téléchargement gratuit</a>
        <a class="btn btn-outline-dark w-100" href="https://www.creative-tim.com/learning-lab/bootstrap/overview/material-dashboard">Voir documentation</a>
        <div class="w-100 text-center">
          <a class="github-button" href="https://github.com/creativetimofficial/material-dashboard" data-icon="octicon-star" data-size="large" data-show-count="true" aria-label="Star creativetimofficial/material-dashboard on GitHub">Star</a>
          <h6 class="mt-3">Merci pour le partage !</h6>
          <a href="https://twitter.com/intent/tweet?text=Check%20Material%20UI%20Dashboard%20made%20by%20%40CreativeTim%20%23webdesign%20%23dashboard%20%23bootstrap5&amp;url=https%3A%2F%2Fwww.creative-tim.com%2Fproduct%2Fsoft-ui-dashboard" class="btn btn-dark mb-0 me-2" target="_blank">
            <i class="fab fa-twitter me-1" aria-hidden="true"></i> Tweet
          </a>
          <a href="https://www.facebook.com/sharer/sharer.php?u=https://www.creative-tim.com/product/material-dashboard" class="btn btn-dark mb-0 me-2" target="_blank">
            <i class="fab fa-facebook-square me-1" aria-hidden="true"></i> Partage
          </a>
        </div>
      </div>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/material-dashboard.min.js?v=3.0.4"></script>
</body>

</html>