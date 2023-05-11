<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta id="csrf-token" content="{{ csrf_token() }}">
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
    const nameDiv = document.createElement("div")
    const priceDiv = document.createElement("div")
    const descriptionDiv = document.createElement("div")

    const labelForm = document.createElement("label")
    labelForm.setAttribute("for", "newArticle")

    const labelText = document.createTextNode("Create new article")
    labelForm.appendChild(labelText)

    const form = document.createElement("form")

    form.setAttribute("action", "/article")
    form.setAttribute("method", "POST")
    form.setAttribute("id", "formNewArticle")
    form.setAttribute("name", "formNewArticle")


    // create label and input for article name
    const labelName = document.createElement("label")
    labelName.setAttribute("for", "articleName")
    const labelNameText = document.createTextNode("Name:")
    labelName.appendChild(labelNameText)

    const nameInput = document.createElement("input")
    nameInput.setAttribute("type", "text")
    nameInput.setAttribute("id", "articleName")
    nameInput.setAttribute("name", "articleName")

    nameDiv.appendChild(labelName).append(document.createElement("br"))
    nameDiv.appendChild(nameInput)

    // create label and input for article price
    const labelPrice = document.createElement("label")
    labelPrice.setAttribute("for", "price")
    const labelPriceText = document.createTextNode("Price:")
    labelPrice.appendChild(labelPriceText)

    const priceInput = document.createElement("input")
    priceInput.setAttribute("type", "number")
    priceInput.setAttribute("id", "price")
    priceInput.setAttribute("name", "price")

    priceDiv.appendChild(labelPrice).append(document.createElement("br"))
    priceDiv.appendChild(priceInput)

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

    descriptionDiv.appendChild(labelDescription).append(document.createElement("br"))
    descriptionDiv.appendChild(descriptionTextarea)

    // create button
    const button = document.createElement("input")
    button.setAttribute("type", "button")
    button.setAttribute("id", "submitButton")
    button.setAttribute("value", "Submit")

    form.appendChild(document.createElement("br"))
    form.appendChild(nameDiv)
    form.appendChild(document.createElement("br"))
    form.appendChild(priceDiv)
    form.appendChild(document.createElement("br"))
    form.appendChild(descriptionDiv)
    form.appendChild(document.createElement("br"))
    form.appendChild(button)



    div.appendChild(labelForm)
    div.appendChild(form)
    div.appendChild(document.createElement("br"))
    document.body.appendChild(div)


    const nameErrDiv = document.createElement("div")
    nameErrDiv.setAttribute("style", "color:red; font-size:10px")
    const nameErrMsg = document.createTextNode("Article name cannot be empty")
    nameErrDiv.appendChild(nameErrMsg)

    const priceErrDiv = document.createElement("div")
    priceErrDiv.setAttribute("style", "color:red; font-size: 10px")
    const priceErrMsg = document.createTextNode("Price cannot be empty or less than 0")
    priceErrDiv.appendChild(priceErrMsg)

    const responseDiv = document.createElement("div")
    responseDiv.setAttribute("style", "font-size: 15px;")
    const responseMsg = document.createTextNode("")
    responseDiv.appendChild(responseMsg)


    document.getElementById("submitButton").addEventListener("click", event => {
        let name = document.getElementById("articleName").value
        let price = document.getElementById("price").value
        let description = document.getElementById("description").value
        responseMsg.nodeValue = ""

        if (name !== "" && name.replaceAll(" ", "").length !== 0 && price > 0 && !isNaN(price) && price !== "")
            sendData(name, price, description)

        if (name === "" || name.replaceAll(" ", "").length === 0)
            nameDiv.append(nameErrDiv)
        else
            nameErrDiv.remove()

        if (price <= 0 || isNaN(price) || price === "")
            priceDiv.append(priceErrDiv)
        else
            priceErrDiv.remove()

        event.preventDefault() // prevent browser from sending the form again
        return false
    })

    function sendData (name, price, description) {
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "/article")
        xhr.setRequestHeader("X-CSRF-TOKEN", document.getElementById("csrf-token").getAttribute("content"))
        xhr.setRequestHeader('Content-Type', 'application/json')

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                responseMsg.nodeValue = xhr.response
                div.appendChild(responseDiv)

                if (xhr.status === 201) {
                    responseDiv.setAttribute("style", "color: green")
                    // clear all inputs
                    document.forms["formNewArticle"].reset()
                }
                else
                    responseDiv.setAttribute("style", "color: red")

                console.log(xhr.responseText)
            }
        }
        // handle web server response
        let data = {
            articleName: name,
            price: price,
            description: description
        }

        xhr.send(JSON.stringify(data))
    }


</script>

</body>
</html>

