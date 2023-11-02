let deferredPrompt; // This variable is used to keep the event for later use.

window.addEventListener('beforeinstallprompt', (event) => {
  console.log('beforeinstallprompt event fired');
  event.preventDefault(); // Prevent the immediate prompt
  deferredPrompt = event; // Save the event for later use
  // You can update your UI here to notify the user that the app can be installed
  document.getElementById('install-button').style.display = 'block'; // Assuming you have a button with id 'install-button'
});

// The function to call when the install button is clicked
function installApp() {
  if (!deferredPrompt) { // If there's no stored event, there's nothing to do
    return;
  }
  // Otherwise, show the install prompt (this is the part that must be user-triggered)
  deferredPrompt.prompt();

  // Handle the user's response
  deferredPrompt.userChoice.then((choiceResult) => {
    if (choiceResult.outcome === 'accepted') {
      console.log('User accepted the install prompt');
    } else {
      console.log('User dismissed the install prompt');
    }
    deferredPrompt = null;
  });
}

// Attach the function to the button (assuming you have a button with id 'install-button')
document.getElementById('install-button').addEventListener('click', installApp);