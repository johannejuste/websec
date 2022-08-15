// ##############################
function validate() {
  var elements_to_validate = all("[data-validate]")
  elements_to_validate.forEach(function (element) { element.parentNode.classList.remove("validate_error") })
  elements_to_validate.forEach(function (element) {
    switch (element.getAttribute("data-validate")) {
      case "str":

        console.log("dlaksædkasdksad")
        if (element.value.length < parseInt(element.getAttribute("data-min")) ||
          element.value.length > parseInt(element.getAttribute("data-max"))
        ) {
          element.parentNode.classList.add("validate_error")
        }
        break;
      case "int":
        if (!parseInt(element.value) ||
          parseInt(element.value.length) < parseInt(element.getAttribute("data-min")) ||
          parseInt(element.value.length) > parseInt(element.getAttribute("data-max"))
        ) {
          element.parentNode.classList.add("validate_error")
        }
        break;
      case "email":
        const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (!re.test(element.value.toLowerCase())) {
          element.parentNode.classList.add("validate_error")
        }
        break;
      case "match":
        if (!(element.value) || element.value != one(`[name='${element.getAttribute("data-match-name")}']`).value) {
          element.parentNode.classList.add("validate_error")
        }
        break;
      case "file":
        if (
          parseInt(element.files.length) < parseInt(element.getAttribute("data-min")) ||
          parseInt(element.files.length) > parseInt(element.getAttribute("data-max"))
        ) {
          console.log(parseInt(element.files.length), "min:", parseInt(element.getAttribute("data-min")), "max:", parseInt(element.getAttribute("data-max")))
          element.parentNode.classList.add("validate_error")
        }

        break;
    }
  })
  return one(".validate_error", event.target) ? false : true



}

// ##############################
function clear_validate_error() {
  event.target.parentNode.classList.remove("validate_error")
}

let elements_to_validate = all("[data-validate]")
elements_to_validate.forEach(element => {
  element.addEventListener("click", () => {
    clear_validate_error();
  })
})

// ##############################
function one(q, from = document) { return from.querySelector(q) }
function all(q, from = document) { return from.querySelectorAll(q) }











