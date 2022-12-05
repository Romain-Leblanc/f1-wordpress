(function ($) {
    $(document).ready(function () {
        // Converti les données JSON dans le tableau HTML
        function getDataFromReq(data) {
            let arrayDataReq = data.ConstructorStandings;
            arrayDataReq.forEach(element => {
                // Sélectionne les élements du DOM
                let tbody = document.getElementById("tbody");
                let tr = document.createElement('tr');
                let tdPosition = document.createElement('td');
                let tdNom = document.createElement('td');
                let tdPoints = document.createElement('td');
                // Définit les valeurs du tableau
                tdPosition.innerText = element.position;
                tdNom.innerText = element.Constructor.name.toUpperCase();
                tdPoints.innerText = element.points;
                // Ajoute chaque <td> dans le <tr>
                tr.appendChild(tdPosition);
                tr.appendChild(tdNom);
                tr.appendChild(tdPoints);
                // Ajoute le <tr> au tableau
                tbody.appendChild(tr);
            });
        }

        // Récupère les données JSON de l'api ERGAST.com
        $.ajax({
            url: "https://ergast.com/api/f1/2022/constructorStandings.json",
            method: "GET",
            dataType: "json"
        })
        .done((response) => {
            getDataFromReq(response.MRData.StandingsTable.StandingsLists[0]);
        })
        .fail((error) => console.log("La requête s'est terminée en échec. Infos : " + JSON.stringify(error)));
    });
})(jQuery);