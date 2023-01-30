<?php
$faq = $sections[1]; //je récupère la première section
$n = sizeof($faq)/2;
?>

<section>
    <h2 class="default-margin">Foire Aux Questions</h2>
    <div class="accordion">
        <div class="accordion-item">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse0" aria-expanded="true" aria-controls="collapse0">
                <?= $faq[0] ?>
            </button>
        </div>
        <div id="collapse0" class="accordion-collapse collapse border show" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <?= $faq[1] ?>
            </div>
        </div>
        <?php
        for ($k = 1; $k < $n; $k++) {
            $q = $faq[2*$k];
            $r = $faq[2*$k+1];
            echo <<<FIN
            <div class="accordion-item">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse$k" aria-expanded="false" aria-controls="collapse$k">
                    $q
                </button>
                <div id="collapse$k" class="accordion-collapse collapse border" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                     $r
                    </div>
                </div>
            </div>
FIN;
        }
        ?>
    <p id="about-messageFin" class="default-margin">Tu n'as pas trouvé ta réponse, n'hésites pas à <a href="?page=Contact">nous contacter.</a></p>
    </div>
    
</section>
