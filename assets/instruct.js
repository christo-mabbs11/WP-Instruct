// Get those steps form the page
var instruct_steps = JSON.parse(instruct_object.instruct_string);

// If there is a value here

// Define the tour!
var tour = {
id: "hello-hopscotch",
    steps: [
        {
            title: "My Header",
            content: "This is the header of my page.",
            target: "header",
            placement: "right"
        },
        {
            title: "My content",
            content: "Here is where I put my content.",
            target: document.querySelector("body"),
            placement: "bottom"
        }
    ]
};

// Start the tour!
hopscotch.startTour(tour);