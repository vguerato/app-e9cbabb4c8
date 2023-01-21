<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <link href="https://cdn.jsdelivr.net/npm/gridjs/dist/theme/mermaid.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="container px-5 py-5">
            <form>
                <div class="uploader">
                    <input type="file" name="file" id="file-picker" required>
                    <label for="file-picker"></label>
                </div>
            </form>

            <div id="table" class="shadow-none"></div>
        </div>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/gridjs/dist/gridjs.umd.js"></script>
        <script>
            const grid = new gridjs.Grid({
                columns: ['Path', 'Value'],
                data: [],
                search: true,
                pagination: true
            }).render(document.getElementById('table'));

            const uploader = document.getElementById('file-picker');
            uploader.onchange = function () {
                const label = this.parentElement.querySelector('label')
                const file = this.files[0]
                if (file) {
                    label.innerHTML = file.name;

                    const data = new FormData();
                    data.append('file', file)

                    fetch('http://localhost:8000/api/import', {
                        method: 'POST',
                        body: data
                    })
                        .then((response) => response.json())
                        .then((result) => {
                            grid.updateConfig({ data: result }).forceRender();
                        })
                        .catch((error) => {
                            alert('Error: ' + error);
                        });
                }
            }
        </script>
    </body>
</html>
