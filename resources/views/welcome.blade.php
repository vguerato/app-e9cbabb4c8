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

            <input
                type="text"
                id="search"
                class="form-control my-4"
                oninput="table.search(this.value)"
                placeholder="Search for some term"
            />

            <table id="paths-table" class="table">
                <thead>
                    <tr>
                        <td>Path</td>
                        <td>Value</td>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script>
            const table = {
                el: document.querySelector('#paths-table tbody'),

                insert(data) {
                    const row = document.createElement('tr');
                    for (const key in data) {
                        const column = document.createElement('td')
                        column.textContent = data[key]
                        row.appendChild(column)
                    }

                    this.el.appendChild(row)
                },

                clear() {
                    this.el.innerHTML = null
                },

                search(term) {
                    this.el.querySelectorAll('tr').forEach(el => {
                        if (el.outerHTML.includes(term)) {
                            el.style.display = 'table-row';
                        } else {
                            el.style.display = 'none';
                        }
                    })
                }
            }

            const uploader = document.getElementById('file-picker');
            uploader.onchange = function () {
                const label = this.parentElement.querySelector('label')
                const file = this.files[0]
                if (file) {
                    label.innerHTML = file.name;

                    const data = new FormData();
                    data.append('file', file)

                    fetch('{{ env('APP_URL') }}:{{ env('APP_PORT') }}/api/import', {
                        method: 'POST',
                        body: data,
                        headers: {
                            'Accept': 'application/json'
                        }
                    })
                        .then((response) => response.json())
                        .then((result) => {
                            if (result) {
                                table.clear()
                                result.forEach(data => table.insert(data))
                            }
                        })
                        .catch((error) => {
                            alert('Error: ' + error);
                        });
                }
            }
        </script>
    </body>
</html>
