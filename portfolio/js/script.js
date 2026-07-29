/* =========================================
   MODERN DARK PORTFOLIO WEBSITE
   JAVASCRIPT FUNCTIONALITY
========================================= */


/* ================= MOBILE SIDEBAR ================= */


const sidebar = document.querySelector(".sidebar");


const menuButton = document.querySelector(".menu-toggle");


if(menuButton){

    menuButton.addEventListener("click",()=>{

        sidebar.classList.toggle("active");

    });

}



/* Close sidebar after clicking a link */


document.querySelectorAll(".sidebar a")
.forEach(link=>{

    link.addEventListener("click",()=>{

        sidebar.classList.remove("active");

    });

});



/* ================= ACTIVE NAVIGATION ================= */


const sections =
document.querySelectorAll("section");


const navLinks =
document.querySelectorAll("nav a");



window.addEventListener("scroll",()=>{


    let current="";


    sections.forEach(section=>{


        const sectionTop =
        section.offsetTop - 150;


        if(scrollY >= sectionTop){

            current =
            section.getAttribute("id");

        }


    });



    navLinks.forEach(link=>{


        link.parentElement.classList.remove("active");



        if(link.getAttribute("href")
        === "#" + current){


            link.parentElement
            .classList.add("active");


        }


    });


});



/* ================= SCROLL REVEAL ================= */


const revealElements =
document.querySelectorAll(
".service-card, .project, .testimonial, .stat, .contact-left, .contact-right"
);



function revealOnScroll(){


    revealElements.forEach(element=>{


        const position =
        element.getBoundingClientRect()
        .top;


        const screenHeight =
        window.innerHeight;



        if(position < screenHeight - 100){


            element.classList.add("reveal");



            setTimeout(()=>{

                element.classList.add("active");

            },100);


        }


    });


}



window.addEventListener(
"scroll",
revealOnScroll
);


revealOnScroll();



/* ================= COUNTER ANIMATION ================= */


const counters =
document.querySelectorAll(".stat h2");



let started=false;



function startCounter(){


    const statsSection =
    document.querySelector(".stats");


    if(!statsSection) return;



    const position =
    statsSection.getBoundingClientRect()
    .top;



    if(position < window.innerHeight-100
    && !started){


        started=true;



        counters.forEach(counter=>{


            const target =
            parseInt(
            counter.innerText
            );


            let count=0;



            const update=()=>{


                const increment =
                Math.ceil(target/100);



                count += increment;



                if(count < target){


                    counter.innerText =
                    count + "+";


                    requestAnimationFrame(update);


                }

                else{


                    counter.innerText =
                    target + "+";


                }


            };


            update();


        });


    }


}


window.addEventListener(
"scroll",
startCounter
);



/* ================= SMOOTH SCROLL ================= */


document.querySelectorAll(
'a[href^="#"]'
)
.forEach(anchor=>{


    anchor.addEventListener(
    "click",
    function(e){


        const target =
        document.querySelector(
        this.getAttribute("href")
        );


        if(target){


            e.preventDefault();


            target.scrollIntoView({

                behavior:"smooth"

            });


        }


    });


});



/* ================= PORTFOLIO HOVER ================= */


const projects =
document.querySelectorAll(".project");



projects.forEach(project=>{


    project.addEventListener(
    "mousemove",
    e=>{


        const rect =
        project.getBoundingClientRect();



        const x =
        e.clientX - rect.left;


        const y =
        e.clientY - rect.top;



        project.style.transform =
        `
        perspective(800px)
        rotateX(${-(y-rect.height/2)/20}deg)
        rotateY(${(x-rect.width/2)/20}deg)
        scale(1.03)
        `;


    });



    project.addEventListener(
    "mouseleave",
    ()=>{


        project.style.transform =
        "scale(1)";


    });


});



/* ================= BUTTON RIPPLE ================= */


const buttons =
document.querySelectorAll(
"button, .primary-btn, .talk-btn, .hire-btn"
);



buttons.forEach(button=>{


    button.addEventListener(
    "click",
    function(e){


        const ripple =
        document.createElement("span");


        ripple.className =
        "ripple";



        const rect =
        this.getBoundingClientRect();



        ripple.style.left =
        e.clientX - rect.left + "px";


        ripple.style.top =
        e.clientY - rect.top + "px";



        this.appendChild(ripple);



        setTimeout(()=>{

            ripple.remove();

        },600);



    });


});



/* ================= CONTACT FORM ================= */


const form =
document.querySelector("form");



if(form){


form.addEventListener(
"submit",
(e)=>{


    e.preventDefault();



    const inputs =
    form.querySelectorAll(
    "input, textarea"
    );



    let valid=true;



    inputs.forEach(input=>{


        if(input.value.trim()===""){


            valid=false;


            input.style.borderColor =
            "#EC4899";


        }


        else{


            input.style.borderColor =
            "rgba(255,255,255,.08)";


        }


    });



    if(valid){


        alert(
        "Message sent successfully!"
        );


        form.reset();


    }

});


}



/* ================= TYPING EFFECT ================= */


const headline =
document.querySelector(".hero h2");



if(headline){


const text =
headline.innerText;


headline.innerText="";


let index=0;



function type(){


    if(index < text.length){


        headline.innerHTML +=
        text.charAt(index);


        index++;


        setTimeout(type,40);


    }


}



type();


}



/* ================= BACK TO TOP ================= */


const backTop =
document.querySelector(
".back-top"
);



if(backTop){


backTop.addEventListener(
"click",
()=>{


window.scrollTo({

    top:0,

    behavior:"smooth"

});


});


}



/* ================= CURSOR GLOW ================= */


const cursor =
document.createElement("div");


cursor.className =
"cursor-glow";


document.body.appendChild(cursor);



document.addEventListener(
"mousemove",
e=>{


cursor.style.left =
e.clientX + "px";


cursor.style.top =
e.clientY + "px";


});



/* ================= PAGE LOADING ================= */


window.addEventListener(
"load",
()=>{


document.body.classList.add(
"loaded"
);


});
