<?php
$n = sizeof($sections);
$numbers = array("Two", "Three", "Four", "Five", "Six", "Seven", "Height", "Nine", "Ten", "Eleven", "Twelve");
?>

<section>
    <h2 class="aboutH2">FAQ</h2>
    <div class="accordion">
        <div class="accordion-item">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                <?= $sections[0][0] ?>
            </button>
        </div>
        <div id="collapseOne" class="accordion-collapse collapse border show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <?= $sections[0][1] ?>
            </div>
        </div>
        <?php
        for ($k = 1; $k < $n; $k++) {
            $letters = $numbers[$k];
            $section = $sections[$k];
            echo <<<FIN
            <div class="accordion-item">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse$letters" aria-expanded="false" aria-controls="collapse$letters">
                    $section[0]
                </button>
                <div id="collapse$letters" class="accordion-collapse collapse border" aria-labelledby="heading$letters" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                     $section[1]
                    </div>
                </div>
            </div>
            FIN;
        }
        ?>
    </div>
</section>
