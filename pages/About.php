<?php
$n = 3;
$numbers = array("Two", "Three", "Four");
?>

<section>
    <div class="accordion">
        <?php
        echo <<<END
        <div class="accordion-item">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                Pourquoi partir de Bordeaux ?
            </button>
        </div>
        <div id="collapseOne" class="accordion-collapse collapse border show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                Parce que c'est là que se trouvait le drapeau de polytechnique pendant la seconde guerre mondiale. Alors que Bordeaux était en zone occupée, trois étudiants ont franchis la ligne pour ramener le drapeau à Lyon où se situait l'école à l'époque.
            </div>
        </div>
        END;

        for ($k = 0; $k < $n; $k++) {
            $letters = $numbers[$k];
            echo <<<END
            <div class="accordion-item">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse$letters" aria-expanded="false" aria-controls="collapse$letters">
                    $k
                </button>
                <div id="collapse$letters" class="accordion-collapse collapse border" aria-labelledby="heading$letters" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        Des mini-bus seront chargés de vous emmener aux points de départ et de vous reprendre à chaque fin de course. Ils vous emmeneront aussi aux zones de récupération où vous pourrez dormir.
                    </div>
                </div>
            </div>
            END;
        }
        ?>
    </div>
</section>

Quelle distance ?
        Il y a 860 kms de course divisés en tronçons de 12km. Chaque tronçon est prévu pour être couru à 10km/h pour que chaque trinôme puisse tenir le rythme.

        Comment me rendre au point de départ ?
        Des mini-bus seront chargés de vous emmener aux points de départ et de vous reprendre à chaque fin de course. Ils vous emmeneront aussi aux zones de récupération où vous pourrez dormir.