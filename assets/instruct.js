////////////////////////////////////////////////////////////////////////////////////////////////////////
// No need or conditionals, this script is only addd to the page when instructions have been added in //
////////////////////////////////////////////////////////////////////////////////////////////////////////

// Get those steps form the page
var instruct_steps = JSON.parse(instruct_object.instruct_string);

// Loop through the object steps
var steps = Array();
instruct_steps.forEach(function(element) {
  // Save the details in a new array
  var temp = {
    title: element.ba_re_text_field_id_name,
    content: element.ba_re_textarea_field_id,
    target: document.querySelector(element.ba_re_text_field_id_selector),
    placement: "bottom"
  };

  // Add this to the new array
  steps.push(temp);
});

// Define the tour!
var tour = {
  id: "page-hopscotch",
  steps: steps
};

// Start the tour!
hopscotch.startTour(tour);
