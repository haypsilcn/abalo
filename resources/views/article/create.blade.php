<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Article</title>
</head>
<body>
    @if (session()->has('fail'))
        <div class="alert alert-danger">
            {{ session()->get('fail') }}
        </div>
        <br>
    @endif

<script>
    "use strict"
    const div = document.createElement("div")
    const labelForm = document.createElement("label")
    labelForm.setAttribute("for", "newarticle")

    const labelText = document.createTextNode("Create new article")
    labelForm.appendChild(labelText)

    const form = document.createElement("form")

    form.setAttribute("action", "/article")
    form.setAttribute("method", "POST")
    form.setAttribute("id", "submitForm")

    // this equivalent to @csrf to validate request
    const csrf = document.createElement("input")
    csrf.setAttribute("type", "hidden")
    csrf.setAttribute("name", "_token")
    csrf.setAttribute("value", "{{ csrf_token() }}")

    // create label and input for article name
    const labelName = document.createElement("label")
    labelName.setAttribute("for", "articleName")
    const labelNameText = document.createTextNode("Name:")
    labelName.appendChild(labelNameText)

    const nameInput = document.createElement("input")
    nameInput.setAttribute("type", "text")
    nameInput.setAttribute("id", "articleName")
    nameInput.setAttribute("name", "articleName")

    // create label and input for article price
    const labelPrice = document.createElement("label")
    labelPrice.setAttribute("for", "price")
    const labelPriceText = document.createTextNode("Price:")
    labelPrice.appendChild(labelPriceText)

    const priceInput = document.createElement("input")
    priceInput.setAttribute("type", "number")
    priceInput.setAttribute("id", "price")
    priceInput.setAttribute("name", "price")

    // create label and input for article description
    const labelDescription = document.createElement("label")
    labelDescription.setAttribute("for", "description")
    const labelDescriptionText = document.createTextNode("Description:")
    labelDescription.appendChild(labelDescriptionText)

    const descriptionTextarea = document.createElement("textarea")
    descriptionTextarea.setAttribute("id", "description")
    descriptionTextarea.setAttribute("name", "description")
    descriptionTextarea.setAttribute("rows", "4")
    descriptionTextarea.setAttribute("cols", "40")

    // create button
    const button = document.createElement("input")
    button.setAttribute("type", "button")
    button.setAttribute("onclick", "checkForm()")
    button.setAttribute("value", "Submit")

    form.appendChild(csrf)
    form.appendChild(labelName)
    form.appendChild(document.createElement("br"))
    form.appendChild(nameInput)
    form.appendChild(document.createElement("br"))
    form.appendChild(labelPrice)
    form.appendChild(document.createElement("br"))
    form.appendChild(priceInput)
    form.appendChild(document.createElement("br"))
    form.appendChild(labelDescription)
    form.appendChild(document.createElement("br"))
    form.appendChild(descriptionTextarea)
    form.appendChild(document.createElement("br"))
    form.appendChild(document.createElement("br"))
    form.appendChild(button)

    div.appendChild(labelForm)
    div.appendChild(form)
    document.body.appendChild(div)

    function checkForm() {
        let name = document.getElementById("articleName").value
        let price = document.getElementById("price").value

        if (name === "")
            alert("Article name cannot be empty")
        else if (price <= 0 || isNaN(price) || price === "")
            alert("Price cannot be empty or less than 0")
        else
            document.getElementById("submitForm").submit()
    }

</script>

</body>
</html>

