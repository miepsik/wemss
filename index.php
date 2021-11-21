<?php
// Start the session
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: user.php?msg=Register or log in first&l=t");
    exit();
}
?>
<?php if ($_SERVER["HTTPS"] != "on") {
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
} ?>
<!doctype html>

<?php
$row = 1;
$options = array();
if (($handle = fopen("data/values.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 5000, "#")) !== FALSE) {
        $options[] = $data;
        $row++;
    }
    fclose($handle);
}
$position = array();
if (($handle = fopen("data/position.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 5000, "#")) !== FALSE) {
        $position[] = $data;
        $row++;
    }
    fclose($handle);
}
$type = array();
if (($handle = fopen("data/type.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 5000, "#")) !== FALSE) {
        $type[] = $data;
        $row++;
    }
    fclose($handle);
}

$answer = array();
if (($handle = fopen("data/answer.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 5000, "#")) !== FALSE) {
        $answer[$data[0]] = $data[1];
        $row++;
    }
    fclose($handle);
}

$datab = count($answer) - 1;
$methodsc = -1;
if (($handle = fopen("data/database.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 5000, ",")) !== FALSE) {
        $methodsc++;
    }
    fclose($handle);
}
ob_start();
require_once('database2.php');
$methodsc = ob_get_clean();
//$datab = 18;

?>


<html class="no-js" lang="en" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">

<head>
    <meta charset="utf-8">

    <!--====== Title ======-->
    <title>WEMSS</title>

    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/png">

    <!--====== Slick CSS ======-->
    <link rel="stylesheet" href="assets/css/slick.css">

    <!--====== Font Awesome CSS ======-->
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">

    <!--====== Line Icons CSS ======-->
    <link rel="stylesheet" href="assets/css/LineIcons.css">

    <!--====== Animate CSS ======-->
    <link rel="stylesheet" href="assets/css/animate.css">

    <!--====== Magnific Popup CSS ======-->
    <link rel="stylesheet" href="assets/css/magnific-popup.css">

    <!--====== Bootstrap CSS ======-->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!--====== Default CSS ======-->
    <link rel="stylesheet" href="assets/css/default.css">

    <!--====== Style CSS ======-->
    <link rel="stylesheet" href="assets/css/style.css">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="css/mcda.css">
    <link rel="stylesheet" href="css/multiple-select.css">

</head>

<body style="background-color: #f2f2f2">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="https://www.w3schools.com/lib/w3.js"></script>
<script src="js/multiple-select.js"></script>
<!--[if IE]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade
    your browser</a> to improve your experience and security.</p>
<![endif]-->


<!--====== PRELOADER PART START ======-->

<div class="preloader">
    <div class="loader">
        <div class="ytp-spinner">
            <div class="ytp-spinner-container">
                <div class="ytp-spinner-rotator">
                    <div class="ytp-spinner-left">
                        <div class="ytp-spinner-circle"></div>
                    </div>
                    <div class="ytp-spinner-right">
                        <div class="ytp-spinner-circle"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--====== PRELOADER PART ENDS ======-->

<!--====== HEADER PART START ======-->

<header class="header-area">
    <div class="navbar-area headroom">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <nav class="navbar navbar-expand-lg">
                        <a class="navbar-brand" href="index.php">
                            <img src="assets/images/logo.png" alt="Logo" style="max-height: 35px">
                        </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                            <span class="toggler-icon"></span>
                            <span class="toggler-icon"></span>
                            <span class="toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                            <ul id="nav" class="navbar-nav m-auto">
                                <li class="nav-item">
                                    <a href="#about">About </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#questionnaire">Find your weighting method</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#method">Weighting methods</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#note">FAQs</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#contact">Contact</a>
                                </li>
                            </ul>
                        </div> <!-- navbar collapse -->

                        <div class="navbar-btn d-none d-lg-inline-block">
                            <img src="assets/pict/putLogo.svg" class="img-fluid logo">
                            <img src="assets/pict/UNEP_LCI2.png" class="img-fluid logo">
                            <img src="assets/pict/Logo_LUC_The_Hague.png" class="img-fluid logo">
                        </div>
                    </nav> <!-- navbar -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </div> <!-- navbar area -->

</header>

<!--====== HEADER PART ENDS ======-->

<!--====== ABOUT PART START ======-->

<div class="fixed-bottom alert alert-info">
    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
    We only use strictly necessary cookies
    for the system features to verify if the user is logged in and has access to the
    different sections of the software. By closing this notice or continuing to explore
    our pages, you accept the use of these cookies.
</div>

<section id="about" class="about-area pt-80">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="about-title text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.3s">
                    <h5 class="title">Find the most relevant <b>weighting methods</b>
                        for

                        your decision-making problem with our<br>

                        <b>WEighting Methods Selection Software (WEMSS)</b></h5>
                </div>
            </div>
        </div> <!-- row -->

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="about-content pt-15">
                    <p class="text wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.4s">The
                        <span>process</span> is <span>structured</span>.
                        As the tool walks you through, you provide answers to the questions you see below.<br>
                        The questions are grouped in three sections to describe the decision-making problem
                        as follows:
                        <br>
                        1. <span class="font-weight-bold">Classifiers</span> : They shape the operational capabilities
                        of the required method
                        <br>
                        2. <span class="font-weight-bold">Intrinsic criteria</span>: They shape the intrinsic nature
                        of the required method
                        <br>
                        3. <span class="font-weight-bold">Implementation criteria</span>:
                        They are used to define the requirements for implementation of the method

                    </p>
                    <div class="about-counter">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="single-counter counter-color-1 mt-30 d-flex wow fadeInUp"
                                     data-wow-duration="1s" data-wow-delay="0.3s">
                                    <div class="counter-shape">
                                        <img src="assets/pict/znaki.png">
                                    </div>
                                    <div class="counter-content media-body">
                                        <span class="counter-count"><span
                                                    class="counter"><?php echo $methodsc; ?></span></span>
                                        <p class="text">Weighting Methods</p>
                                    </div>
                                </div> <!-- single counter -->
                            </div>
                            <div class="col-sm-4">
                                <div class="single-counter counter-color-2 mt-30 d-flex wow fadeInUp"
                                     data-wow-duration="1s" data-wow-delay="0.6s">
                                    <div class="counter-shape">
                                        <img src="assets/pict/wykres.png">
                                    </div>
                                    <div class="counter-content media-body">
                                        <span class="counter-count"><span
                                                    class="counter"><?php echo $datab ?></span></span>
                                        <p class="text">key decision-making features</p>
                                    </div>
                                </div> <!-- single counter -->
                            </div>
                            <div class="col-sm-3">
                                <div class="single-counter counter-color-3 mt-30 d-flex wow fadeInUp"
                                     data-wow-duration="1s" data-wow-delay="0.9s">
                                    <div class="counter-shape">
                                        <img src="assets/pict/tv.png">
                                    </div>
                                    <div class="counter-content media-body">
                                        <span class="counter-count"><span class="counter">1</span></span>
                                        <p class="text">simple user interface</p>
                                    </div>
                                </div> <!-- single counter -->
                            </div>
                        </div> <!-- row -->
                    </div> <!-- about counter -->
                </div> <!-- about content -->
            </div>
        </div> <!-- row -->
    </div> <!-- container -->
</section>

<!--====== ABOUT PART ENDS ======-->

<!--====== OUR SERVICE PART START ======-->

<section id="questionnaire" class="our-services-area pt-15">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="section-title wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                    <div class="row justify-content-center"><h3 class="title">Find your weighting methods</h3></div>
                </div> <!-- section title -->
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="section-title text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                    <p class="text wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.4s">Here is our intuitive and
                        interactive set of questions. Answering them will lead you to a subset of methods relevant to
                        your problem. Under each question you can find its description, while the description of an
                        answer appears when you move the mouse on it.
                    </p>
                    <p class="text wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.4s">Enjoy your journey with
                        the WEMSS!</p>
                    <p class="text wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.4s">Your recommended method(s)
                        will automatically appear at the bottom.
                    </p>
                    <p class="text wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.4s">
                        The numbers in brackets next to each answer indicate the number of methods that will be
                        recommended if you choose such answer. Please note that this a dynamic process, so the number
                        changes according to the combination of answers that you will give.</p>
                    <p class="text wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.4s">
                        If there is terminology you do not understand, you might find the explanation in the <a
                                href="#note">FAQs</a> section at
                        the bottom of the software</p>
                </div> <!-- section title -->
            </div>
        </div> <!-- row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="our-services-tab">
                    <?php
                    $desc = array("1 Classifiers", "2 Intrinsic <br> criteria", "3 Implementation <br> criteria",
                    );
                    $icon = array("bulb", "thought", "search",)
                    ?>

                    <ul class="nav justify-content-center wow fadeIn" data-wow-duration="1s" data-wow-delay="0.5s"
                        id="myTab" role="tablist">
                        <?php
                        for ($i = 0; $i < 3; $i++) {
                            $class = $i < 1 ? "active" : "";
                            echo "<li class=\"nav-item\">
                                <a class=\"{$class}\" id=\"{$i}-tab\" data-toggle=\"tab\" href=\"#tab{$i}\" role=\"tab\" aria-controls=\"tab{$i}\" aria-selected=\"true\">
                                    <i class=\"lni-{$icon[$i]}\"></i> <span>{$desc[$i]}</span>
                                </a>
                            </li>";
                        }


                        ?>
                    </ul>


                    <div class="tab-content wow fadeIn" data-wow-duration="1s" data-wow-delay="0.5s" id="myTabContent">
                        <?php
                        $description = array("
<b>Section 1</b>: They shape the operational capabilities of the required method",
                            "<b>Section 2</b>: They shape the intrinsic nature of the required method
",
                            "<b>Section 3</b>: They are used to define the requirements for implementation of the method",
                        );


                        for ($section = 0; $section < 3; $section++) {
                            $classes = $section < 1 ? "tab-pane fade show active" : "tab-pane fade";
                            echo "
                            <div class=\"{$classes}\" id=\"tab{$section}\" role=\"tabpanel\" aria-labelledby=\"{$section}-tab\">
                                <div class=\"row justify-content-md-center\">
                                    <div class=\"col-lg-10\">
                                        <div class=\"our-services-content mt-15\">
                                            <p class=\"text\">{$description[$section]}</p>";

                            foreach ($options as $i => $opt) {
                                if ($position[$i][1] == $section) {
                                    $el = $position[$i];
                                    $done = true;
                                    $qq = explode(".", $opt[0]);
                                    echo '<div class="row" id="' . $el[0] . '"><div class="col-md-7"><div><strong>' . ucfirst($el[2]) . '</strong></div><div>' . $el[3] . '</div></div>
 <div class="col-md-5"><div class="form-group">
 <select autocomplete="off" class="form-control' . ($type[$i][1] == "M" ? ' multiple' : '') . '" id="s' . $opt[0] . '" ' . ($type[$i][1] == "M" ? 'multiple="multiple"' : '') . '>';
                                    echo '<option value="0" selected="selected">I don\'t know</option>';
                                    for ($i = 1; $i < count($opt); $i++) {
                                        $elop = $el[0] . '*' . $opt[$i];
                                        $title = $opt[$i];
                                        if (array_key_exists($elop, $answer)) {
                                            $title = $answer[$elop];
                                        }
                                        echo "<option title='{$title}' value=\"{$opt[$i]}\">" . $opt[$i] . '</option>';
                                    }
                                    echo '</select><span id="c' . $opt[0] . '" style="margin-left: 5px"></span></div></div></div>';
                                }
                            }

                            echo "</div> <!-- our services content -->
                                    </div>
                                </div> <!-- row -->
                            </div>";

                        }
                        ?>

                        <div class="col-lg-8" style="float: right">
                            <div class="info">
                                <div>
                                    <button type="button" id="suggest" class="btn btn-primary">Most selective questions
                                    </button>
                                    <div class="infotextBtn">You can click this button to see the most selective
                                        questions
                                        (with increasing number of methods) according to the provided answers.
                                    </div>
                                </div>
                                <div class="pt-2">
                                    <button type="button" class="btn btn-primary" style="visibility: hidden">A</button>
                                </div>
                            </div>
                            <div class="info">
                                <div>
                                    <button type="button" id="suggest2" class="btn btn-primary">Most selective questions
                                        in
                                        this section
                                    </button>
                                    <div class="infotextBtn">You can click this button to see the most selective
                                        questions
                                        in this section
                                        (with increasing number of methods) according to the provided answers.
                                    </div>
                                </div>
                                <div class="pt-2">
                                    <button type="button" class="btn btn-primary" style="visibility: hidden;">A</button>
                                </div>
                            </div>


                            <div class="info">
                                <div>
                                    <button type="button" id="sm3" class="btn btn-primary" onclick="show3()">Reset
                                        section
                                    </button>
                                </div>
                                <div class="pt-2">
                                    <button type="button" id="prevBtn" class="btn btn-primary"
                                            style="visibility: hidden">
                                        Previous
                                    </button>
                                </div>
                            </div>
                            <div class="info">
                                <button type="button" id="sm4" class="btn btn-primary" onclick="show4()">Reset all
                                </button>
                                <div class="pt-2">
                                    <button type="button" id="nextBtn" class="btn btn-primary">Next</button>

                                </div>
                            </div>

                        </div>

                        <div style="clear: both"></div>
                        <div id="noResult" style="display: none">
                            <div class="row justify-content-center">
                                <div class="col-lg-9">
                                    There is no method that completely fulfils all these requirements. However, we can
                                    still recommend methods that are as close as possible to your requests. Just <a
                                            role="button"
                                            href="javascript:;"
                                            id='openModal'>click
                                        here</a> to set the decision-making features that you consider binding for this
                                    search.
                                </div>
                            </div>
                        </div>
                    </div> <!-- tab content -->
                </div> <!-- our services tab -->
            </div>
        </div> <!-- row -->
    </div> <!-- container -->
</section>

<!--====== OUR SERVICE PART ENDS ======-->

<!--====== SERVICE PART START ======-->

<section id="method" class="service-area pt-15">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="section-title wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                    <div class="row justify-content-center"><h3 class="title">Weighting methods</h3></div>
                </div> <!-- section title -->
            </div>
        </div> <!-- row -->


        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="col-lg-12">
                    <p class="text wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.4s">
                        Once you answer a part or all questions from the three Sections, the method(s) recommended for
                        your decision-making problem will automatically appear in the list below.
                        <br>
                        If you click on the &#9432; you will see a description of each method with
                        the answers that you chose in bold.
                        <br>
                        When present, the column “Missed features” shows the decision-making features that
                        you selected and which are not supported by the recommended methods.
                    </p>
                </div>
                <div id="methods" class="wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.3s"></div>


            </div>
        </div>


    </div> <!-- container -->
</section>


<!--====== SERVICE PART ENDS ======-->

<section id="note" class="contact-area pt-15 pb-15">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section-title text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.3s">
                    <h3 class="title">FAQs</h3>
                </div> <!-- section title -->
            </div>
        </div> <!-- row -->
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="section-title text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
                    <p class="text wow fadeInUp"></p>
                </div> <!-- section title -->
            </div>
        </div> <!-- row -->
        <div class="row">
            <button class="accordion">What is the purpose of weighting? Why do you apply weights? What can weights be
                used for?
            </button>
            <div class="panel">
                Weighting is the evaluation of the relative importance of impacts, according to (i) specific value
                choices of individuals, groups, populations, or organizations and/or (ii) the statistical structure
                of the input dataset (i.e., data-driven).
            </div>


            <button class="accordion">What are the weights?</button>
            <div class="panel">
                They are parameters used to define the relative importance of impacts. Two main groups of weighting
                methods can be distinguished:
                <ul>
                    <li>Those providing weights as unit-specific compensation (conversion) rates</li>
                    <li>Those providing weights as dimensionless numbers, either reflecting compensation rates or
                        importance coefficients
                    </li>
                </ul>

            </div>


            <button class="accordion">How can weights be obtained?</button>
            <div class="panel">
                There are several methods that can be used to calculate weights. We distinguish four main groups:
                <ol>
                    <li> Distance to target: Define the importance of impacts depending on the distance between the
                        existing impact level and a target level
                    </li>
                    <li> Multiple Criteria Decision Analysis: Define the importance of the impacts according to the
                        preferences of a group of stakeholders or a set of constraints
                    </li>
                    <li> Monetary: Define the importance of impacts in monetary terms</li>
                    <li> Data-driven: Uses the statistical structure of the input dataset to calculate the importance of
                        the impacts
                    </li>
                </ol>

            </div>


            <button class="accordion">What do compensation rates convey?</button>
            <div class="panel">
                Compensation rates indicate the weight of one unit in the respective impact category indicator result
                (e.g., per 1 kg of CO<sub>2</sub> equivalents or 1 kg of SO<sub>2</sub> equivalents). If
                W<sub>x</sub> is the weight of 1 unit in
                impact category indicator x and W<sub>y</sub> is the weight of 1 unit in impact category indicator
                y, then 1
                unit of x is worth the same as (W<sub>x</sub>/<sub>Wy</sub>) units in y. This type of weighting
                factor is used by methods
                where being better in one impact category indicator result can compensate for being worse in another
                impact category indicator. For example, W could be USD/CO<sub>2-eq</sub> for climate change or
                €/DALY for
                respiratory inorganics. Other examples are the W of climate change expressed in kg of
                CO<sub>2-eq</sub> with a
                weight of 1 and the W of acidification per kg of SO<sub>2-eq</sub> with a weight of 2. This
                expression means
                that the improvement of 2 units (i.e., 2 kg of CO<sub>2-eq</sub>) of climate change compensates for
                the
                worsening of 1 unit (i.e., 1 kg of SO<sub>2-eq</sub>) of acidification.
            </div>

            <button class="accordion">What do importance coefficients convey?</button>
            <div class="panel">
                Importance coefficients indicate the intrinsic importance of the impact indicator itself when comparing
                two or more alternatives. If an impact category indicator is given more weight than another one, then it
                is more important to be better in this impact category indicator than in another. This type of weighting
                factor is used by methods where a better result in one impact category may or may not fully compensate
                for a worse result in another impact category. For example, W for climate change could be 35%, W for
                ozone depletion could be 15% and W for eutrophication could be 20%, etc., with the meaning that being
                better in terms of climate change (alone) is as important as being better in terms of ozone depletion
                and eutrophication (simultaneously).
            </div>

            <button class="accordion">What can the GLAM weights be used for?</button>
            <div class="panel">
                The foreseen uses of the GLAM weights include (i) impact contribution analysis and (ii) aggregation.
            </div>

            <button class="accordion">What is a decision recommendation?</button>
            <div class="panel">
                It is the type of decision support that the decision maker would like to receive when using the weights.
            </div>

            <button class="accordion">What types of decision recommendation can be supported with the GLAM weights?
            </button>
            <div class="panel">
                <ul>
                    <li>
                        Scoring = Assign a score to each alternative according to their performance<br>
                        <img src="assets/images/scoring.png">
                    </li>
                    <li>
                        Ranking = Order the alternatives from the most to the least preferred<br>
                        <img src="assets/images/ranking.png">
                    </li>
                    <li>
                        Sorting = Assign the alternatives to pre-defined preference-ordered decision classes<br>
                        <img src="assets/images/sorting.png">
                    </li>

                    <li>
                        Choice = Select the most preferred subset of alternatives<br>
                        <img src="assets/images/choice.png">
                    </li>

                    <li>
                        Clustering = Divide alternatives into groups according to some similarity measure or preference
                        relation)<br>
                        <img src="assets/images/clustering.png">
                    </li>
                </ul>
            </div>

            <button class="accordion">What sustainability perspective can be implemented with the GLAM weights?</button>
            <div class="panel">
                <img src="assets/images/lca.png">
            </div>
        </div> <!-- row -->
    </div> <!-- container -->
</section>

<!--====== PROJECT GALLERY PART START ======-->

<!--====== CONTACT PART START ======-->

<section id="contact" class="contact-area pt-15 pb-15">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="section-title text-center wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.3s">
                    <h3 class="title">Our Contact Information</h3>
                </div> <!-- section title -->
            </div>
        </div> <!-- row -->
        <div class="contact-info">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="single-contact-info contact-color-0 mt-30 d-flex  wow fadeInUp" data-wow-duration="1s"
                         data-wow-delay="0.6s">
                        <div class="contact-info-icon">
                            <i class="lni-envelope"></i>
                        </div>
                        <div class="contact-info-content media-body">
                            <p class="text"><a href="mailto: m.cinelli@luc.leidenuniv.nl  ">Dr. Marco Cinelli</a><sup>1,2</sup>
                            </p>
                            <p class="text"><a href="mailto: grzegorz.miebs@cs.put.poznan.pl">M.Sc. Grzegorz
                                    Miebs</a><sup>2</sup></p>
                        </div>
                    </div> <!-- single contact info -->
                </div>
                <div class="col-lg-5 col-md-6">
                    <div class="single-contact-info contact-color-0 mt-30 d-flex  wow fadeInUp" data-wow-duration="1s"
                         data-wow-delay="0.3s">
                        <div class="contact-info-icon">
                            <i class="lni-map-marker"></i>
                        </div>
                        <div class="contact-info-content media-body">
                            <p class="text"><sup>1</sup> Decision Engineering for Sustainability and Resilience (DESIRE) Laboratory <br>
                                Leiden University College (LUC)<br>
                                Faculty of Governance and Global Affairs, Leiden University<br>
                                Anna van Buerenplein 301<br>
                                2595 DG The Hague<br>
                                The Netherlands<br></p>

                            <p class="text"><sup>2</sup> Laboratory of Intelligent Decision Support Systems<br>
                                Institute of Computing Science <br>
                                Poznań University of
                                Technology <br> 2 Piotrowo Street <br> 60-965 Poznań <br> Poland</p>

                        </div>

                    </div> <!-- single contact info -->
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="single-contact-info contact-color-0 mt-30 d-flex  wow fadeInUp" data-wow-duration="1s"
                         data-wow-delay="0.9s">
                        <div class="contact-info-icon">
                            <i class="lni-phone"></i>
                        </div>
                        <div class="contact-info-content media-body">
                            <p class="text">+39 366 935 5233 <br> (Marco Cinelli)</p>
                        </div>
                    </div> <!-- single contact info -->
                </div>
            </div> <!-- row -->
        </div> <!-- contact info -->
        <div class="row">

        </div> <!-- row -->
    </div> <!-- container -->
</section>

<!--====== CONTACT PART ENDS ======-->

<!--====== FOOTER PART START ======-->

<footer id="footer" class="footer-area bg_cover">
    <div class="container">
        <!-- footer widget -->

        <div class="footer-copyright text-center">
            This project has received funding from the European Union’s Horizon 2020 research and innovation programme
            under grant agreement No 743553, and from the Polish Ministry of Science and Higher Education under the
            Diamond
            Grant project (Grant No. DI2018 004348).
        </div>
        <div class="row justify-content-center" style="margin-bottom: 15px">
            <img src="assets/pict/eu.svg" class="img-fluid logo">

        </div>

        <div class="footer-copyright text-center font-italic row justify-content-center wow fadeInUp"
             data-wow-duration="1s"
             data-wow-delay="0.3s">
            <p>Disclaimer 1: The developers of the WEMSS do not take responsibility for the choices a user takes based
                on the recommendations of the WEMSS.</p>
        </div>

        <div class="footer-copyright text-center">
            <p class="text">© 2022 Crafted by <a href="https://uideck.com" rel="nofollow">UIdeck</a> All Rights
                Reserved.</p>
            <a href="https://www.freepik.com/vectors/illustration">Illustration vector created by stories -
                www.freepik.com</a>
        </div>

    </div> <!-- container -->

    <div id="myModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="modalContent">
                <div class="modal-header">
                    <span class="modal-title">Please select the decision-making features that you consider binding for the search of the relevant MCDA
methods that are as close as possible to your requirements.</span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="close" id="close" aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div id="insertForm"></div>
                </div>
                <div class="modal-footer">
                    <button id="accept">OK</button>
                </div>
            </div>

        </div>
    </div>

    <div id="myModal2" class="modal">
        <div class="modal-content" id="modalContent">
            <span class="close" id="close2">&times;</span>
            <p class="text">Here is a description of the method with the answers that you chose in <b>bold</b>.</p>
            <div id="insertMethod"></div>
        </div>

    </div>

    <div id="myModal3" class="modal">
        <div class="modal-content" id="modalContent">
            <span class="close" id="close3">&times;</span>
            <p class="text">Are you sure you want to reset this section? This will remove all the answers you have
                provided in this section.</p>
            <div id="insertMethod">
                <button type="button" id="reset" class="btn btn-primary">Reset section</button>

            </div>
        </div>

    </div>

    <div id="myModal4" class="modal">
        <div class="modal-content" id="modalContent">
            <span class="close" id="close4">&times;</span>
            <p class="text">Are you sure you want to reset all your answers? This will remove all the answers you have
                provided so far.</p>
            <div id="insertMethod">
                <button type="button" id="resetAll" class="btn btn-primary">Reset all</button>

            </div>
        </div>

    </div>
</footer>

<!--====== FOOTER PART ENDS ======-->

<!--====== BACK TOP TOP PART START ======-->

<a href="#" class="back-to-top"><i class="lni-chevron-up"></i></a>

<!--====== BACK TOP TOP PART ENDS ======-->


<!--====== Jquery js ======-->
<script src="assets/js/vendor/jquery-1.12.4.min.js"></script>
<script src="assets/js/vendor/modernizr-3.7.1.min.js"></script>

<!--====== Bootstrap js ======-->
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

<!--====== Slick js ======-->
<script src="assets/js/slick.min.js"></script>

<!--====== Isotope js ======-->
<script src="assets/js/imagesloaded.pkgd.min.js"></script>
<script src="assets/js/isotope.pkgd.min.js"></script>

<!--====== Counter Up js ======-->
<script src="assets/js/waypoints.min.js"></script>
<script src="assets/js/jquery.counterup.min.js"></script>

<!--====== Circles js ======-->
<script src="assets/js/circles.min.js"></script>

<!--====== Appear js ======-->
<script src="assets/js/jquery.appear.min.js"></script>

<!--====== WOW js ======-->
<script src="assets/js/wow.min.js"></script>

<!--====== Headroom js ======-->
<script src="assets/js/headroom.min.js"></script>

<!--====== Jquery Nav js ======-->
<script src="assets/js/jquery.nav.js"></script>

<!--====== Scroll It js ======-->
<script src="assets/js/scrollIt.min.js"></script>

<!--====== Magnific Popup js ======-->
<script src="assets/js/jquery.magnific-popup.min.js"></script>

<!--====== Main js ======-->
<script src="assets/js/main.js"></script>

<script src="js/mcda.js"></script>
<script src="js/multiple-select.js"></script>

</body>

</html>
