document.addEventListener(
  "click",
  function (event) {
    if (
      event.target.matches(".modal-object-buy") ||
      !event.target.closest(".body-modal")
    ) {
      closeModal()
    }
  },
  false
)

function closeModal() {
  document.querySelector(".modal").style.display = "none"
}