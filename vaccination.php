    <?php
    header("Access-Control-Allow-Origin: *");

    error_reporting(E_ERROR | E_PARSE);
    // if (session_id() != null) session_id(session_id());
    // session_start();

    require_once dirname(__FILE__, 1) . "/controller/controller.php";
    require_once dirname(__FILE__, 1) . "/controller/load_list_countries_controller.php";
    require_once dirname(__FILE__, 1) . "/model/action.php";

    $raw_data_vaccination = file_get_contents("https://raw.githubusercontent.com/owid/covid-19-data/" .
        "master/public/data/vaccinations/vaccinations.json");
    // isset($_POST['nation']) mean this page is loaded by form submiting 
    //(if isset($_POST['nation']) == false ) this page is loaded by URL

    if (isset($_POST['nation'])) {
        $controller = new controller($_POST["nation"], $raw_data_vaccination);
        $controller->generate_json_file(true);
        $file_path = dirname(__FILE__) . ("/json_datas/" . $_SESSION['nation_name'] . "_vaccination.json");
        $filename = $_SESSION['nation_name'] . "_vaccination.json";
        if (!file_exists($file_path)) { // file does not exist
            die('file not found');
        } else {
            header("Content-Disposition: attachment; filename=$filename");
        }
        // $_POST['download_or_see'] == "download"  mean the customer choose 'download'
        if ($_POST['download_or_see'] == "download") {
            // die($file_path);
            readfile($file_path);
            die();
        } else { // or they can choose to see on the browser
            // var_dump($_SERVER['HTTP_HOST'] . '/json_datas/' . $_SESSION['nation_name'] . "_vaccination.json");
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/json_datas/" . $_SESSION['nation_name'] . "_vaccination.json");
        }
    }
    ?>

    <!DOCTYPE html>

    <html class="no-js">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Worldometer Crawler</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="">
    </head>

    <body>
        <h2>
            Choose the RIGHT name of Nation, To receive Covid-19 vaccinations data
        </h2>
        <?
        $loader = new load_list_countries(true, $raw_data_vaccination);
        $list_nations = $loader->list_countries;
        // var_dump($);
        ?>


        <h1>CHoose a nation</h1>
        <form action="vaccination.php" method="POST">
            <input type="text" name="nation" list="nation_name" required />
            <datalist id="nation_name" require>
                <?php foreach ($list_nations as $i => $nation) : ?>
                    <option value="<?= $nation; ?>"><?= $nation; ?></option>
                <?php endforeach; ?>
            </datalist>
            <br>
            <input type="radio" name="download_or_see" value="download"> Download
            <input type="radio" name="download_or_see" value="see"> See Result
            <button type="submit">submit</button>

            <!-- -->
        </form>

        <h3>Click button below to go crawling the COVID-19 cases data</h3>
        <a href="index.php">
            <button>Crawl Covid-19 cases</button>
        </a>

        <script src="" async defer></script>
    </body>

    </html>