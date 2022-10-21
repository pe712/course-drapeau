<?php
$faq = $sections[1]; //je récupère la première section
$n = sizeof($faq)/2;
$numbers = array("Two", "Three", "Four", "Five", "Six", "Seven", "Height", "Nine", "Ten", "Eleven", "Twelve");
?>

<section>
    <h2 class="aboutH2">Foire Aux Questions</h2>
    <div class="accordion">
        <div class="accordion-item">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                <?= $faq[0] ?>
            </button>
        </div>
        <div id="collapseOne" class="accordion-collapse collapse border show" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <?= $faq[1] ?>
            </div>
        </div>
        <?php
        for ($k = 1; $k < $n; $k++) {
            $letter = $numbers[$k];
            $q = $faq[2*$k];
            $r = $faq[2*$k+1];
            echo <<<FIN
            <div class="accordion-item">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse$letter" aria-expanded="false" aria-controls="collapse$letter">
                    $q
                </button>
                <div id="collapse$letter" class="accordion-collapse collapse border" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                     $r
                    </div>
                </div>
            </div>
            FIN;
        }
        ?>
    </div>
    
    <p id="about-messageFin">Tu n'a pas trouvé ta réponse, n'hésites pas à <a href="index.php?page=Contact">nous contacter.</a></p>
</section>
