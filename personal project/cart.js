// Minimal JavaScript for cart functionality

// Add to cart
function addToCart(artworkId) {
  fetch("api/cart.php?action=add", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ artwork_id: artworkId }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        updateCartCount(data.cart_count)
        showNotification("Added to cart!")
      }
    })
    .catch((error) => console.error("Error:", error))
}

// Remove from cart
function removeFromCart(artworkId) {
  if (!confirm("Remove this item from cart?")) return

  fetch("api/cart.php?action=remove", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ artwork_id: artworkId }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        updateCartCount(data.cart_count)
        location.reload()
      }
    })
    .catch((error) => console.error("Error:", error))
}

// Update quantity
function updateQuantity(artworkId, change) {
  const qtyElement = document.querySelector(`[data-item-id="${artworkId}"] .qty-value`)
  const currentQty = Number.parseInt(qtyElement.textContent)
  const newQty = currentQty + change

  if (newQty < 1) {
    removeFromCart(artworkId)
    return
  }

  fetch("api/cart.php?action=update", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      artwork_id: artworkId,
      quantity: newQty,
    }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        qtyElement.textContent = newQty
        updateCartCount(data.cart_count)
        location.reload()
      }
    })
    .catch((error) => console.error("Error:", error))
}

// Update cart count in header
function updateCartCount(count) {
  const cartCountElement = document.getElementById("cartCount")
  if (cartCountElement) {
    cartCountElement.textContent = count
  }
}

// Show notification
function showNotification(message) {
  const notification = document.createElement("div")
  notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: #10b981;
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 0.5rem;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        z-index: 1000;
        animation: slideIn 0.3s ease;
    `
  notification.textContent = message
  document.body.appendChild(notification)

  setTimeout(() => {
    notification.style.animation = "slideOut 0.3s ease"
    setTimeout(() => notification.remove(), 300)
  }, 2000)
}

// Add CSS animations
const style = document.createElement("style")
style.textContent = `
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
`
document.head.appendChild(style)
