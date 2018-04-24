<?php
session_start();

echo $_SESSION['id'];
echo $_SESSION['pseudo'];
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Document</title>
    </head>

    <body>
        <div id="all">
            <div id="scoreDiv">
                <h1>Rapport</h1>
                <p id="agentName"><b>Agent Name: <?php echo $_SESSION['pseudo'] ?></b></p>
                <p id="missionNbr"><b>Mission Number: </b></p>
                <p></p>
                <p id="Statistics"><b>Statistics: </b><br><b>-------------------------------------------------------------------------------------------</b></p>
                <table>
                    <tr>
                        <?php
                        echo '<td><b>Target hit: </b> </td>';
                        echo '<td><b>' . $hits . '</b></td>';
                        echo '<td><b>1 points: </b> </td>';
                        echo '<td><b>' . $point1 . '</b></td>';
                        ?>

                    </tr>
                    <tr>
                        <?php
                        echo '<td><b>Bullets fired: </b></td>';
                        echo '<td><b>' . $fired . '</b></td>';
                        echo '<td><b>2 points: </b></td>';
                        echo '<td><b>' . $point2 . '</b></td>';
                        ?>
                    </tr>
                    <tr>
                        <?php
                        echo '<td><b>Accuracy: </b></td>';
                        echo '<td><b>' . $accuracy . ' % </b></td>';
                        echo '<td><b>3 points: </b></td>';
                        echo '<td><b>' . $point3 . '</b></td>';
                        ?>

                    </tr>
                    <tr>
                        <?php
                        echo '<td><b>Total points: </b></td>';
                        echo '<td><b>' . $points . '</b></td>';
                        echo '<td><b>4 points: </b></td>';
                        echo '<td><b>' . $point4 . '</b></td>';
                        ?>
                    </tr>
                    <tr>
                        <td>----------------</td>
                        <td>----------------</td>
                        <?php
                        echo '<td><b>5 points: </b></td>';
                        echo '<td><b>' . $point5 . '</b></td>';
                        ?>
                    </tr>
                </table>
                <p><b>-------------------------------------------------------------------------------------------</b></p>
                <p id="lieu"><b>Lieu: Geneve</b></p>
            </div>
        </div>
    </body>

    </html>
