/* -----------------------------------------------
/* How to use? : Check the GitHub README
/* ----------------------------------------------- */

/* To load a config file (particles.json) you need to host this demo (MAMP/WAMP/local)... */
/*
particlesJS.load('particles-js', 'particles.json', function() {
  console.log('particles.js loaded - callback');
});
*/

/* Otherwise just put the config content (json): */
particlesJS("particles-js", {
	particles: {
		number: {
			value: 15,
			density: {
				enable: true,
				value_area: 900 //Denser the smaller the number.
			}
		},
		color: {
			//The color for every node, not the connecting lines.
			value: "#01579b" //Or use an array of colors like ["#9b0000", "#001378", "#0b521f"]
		},
		shape: {
			type: "circle", // Can show circle, edge (a square), triangle, polygon, star, img, or an array of multiple.
			stroke: {
				//The border
				width: 1,
				color: "#145ea8"
			},
			polygon: {
				//if the shape is a polygon
				nb_sides: 5
			},
			image: {
				//If the shape is an image
				src: "",
				width: 100,
				height: 100
			}
		},
		opacity: {
			value: 0.2,
			random: true
		},
		size: {
			value: 10,
			random: true
		},
		line_linked: {
			enable: true,
			distance: 200, //The radius before a line is added, the lower the number the more lines.
			color: "#007ecc",
			opacity: 0.2,
			width: 2
		},
		move: {
			enable: true,
			speed: 2,
			direction: "top", //Move them off the canvas, either "none", "top", "right", "bottom", "left", "top-right", "bottom-right" et cetera...
			random: true,
			straight: false, //Whether they'll shift left and right while moving.
			out_mode: "out", //What it'll do when it reaches the end of the canvas, either "out" or "bounce".
			bounce: false,
			attract: {
				//Make them start to clump together while moving.
				enable: true,
				rotateX: 600,
				rotateY: 1200
			}
		}
	},
	//Negate the default interactivity
	interactivity: {
		detect_on: "canvas",
		events: {
			onhover: {
				enable: false,
				mode: "repulse"
			},
			onclick: {
				enable: false,
				mode: "push"
			},
			resize: true
		},
		modes: {
			grab: {
				distance: 800,
				line_linked: {
					opacity: 1
				}
			},
			bubble: {
				distance: 800,
				size: 80,
				duration: 2,
				opacity: 0.3,
				speed: 2
			},
			repulse: {
				distance: 400,
				duration: 0.4
			},
			push: {
				particles_nb: 4
			},
			remove: {
				particles_nb: 2
			}
		}
	},
	retina_detect: true
});
/* particlesJS(
	"particles-js",

	{
		particles: {
			number: {
				value: 15,
				density: {
					enable: true,
					value_area: 800
				}
			},
			color: {
				value: "#ffffff"
			},
			shape: {
				type: "polygon",
				stroke: {
					width: 0,
					color: "#f4f4f4"
				},
				polygon: {
					nb_sides: 4
				},
				image: {
					src: "img/github.svg",
					width: 100,
					height: 100
				}
			},
			opacity: {
				value: 0.06,
				random: false,
				anim: {
					enable: false,
					speed: 1,
					opacity_min: 0.1,
					sync: false
				}
			},
			size: {
				value: 50,
				random: true,
				anim: {
					enable: false,
					speed: 40,
					size_min: 0.1,
					sync: false
				}
			},
			line_linked: {
				enable: true,
				distance: 150,
				color: "#333",
				opacity: 1,
				width: 1
			},
			move: {
				enable: true,
				speed: 6,
				direction: "none",
				random: false,
				straight: false,
				out_mode: "out",
				attract: {
					enable: false,
					rotateX: 600,
					rotateY: 1200
				}
			}
		},
		interactivity: {
			detect_on: "canvas",
			events: {
				onhover: {
					enable: false,
					mode: "repulse"
				},
				onclick: {
					enable: false,
					mode: "push"
				},
				resize: true
			},
			modes: {
				grab: {
					distance: 400,
					line_linked: {
						opacity: 1
					}
				},
				bubble: {
					distance: 400,
					size: 40,
					duration: 2,
					opacity: 8,
					speed: 3
				},
				repulse: {
					distance: 200
				},
				push: {
					particles_nb: 4
				},
				remove: {
					particles_nb: 2
				}
			}
		},
		retina_detect: true,
		config_demo: {
			hide_card: false,
			background_color: "#ffff",
			background_image: "",
			background_position: "50% 50%",
			background_repeat: "no-repeat",
			background_size: "cover"
		}
	}
);*/
