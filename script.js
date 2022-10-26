const body = document.querySelector("body");

const mainNav = document.getElementById("main-nav");
const mainNavCheckBox = document.getElementById("main-nav-check-box");
const mainNavItems = document.querySelectorAll("#main-nav > ul > li");

const sections = document.querySelectorAll("section");

const introDarkMask = document.querySelector("#intro > div");
const introProfileImageLayout = document.querySelector(
  "#intro .profile-image-layout"
);
const introCaption = document.querySelector("#intro .caption");

const skillCheckButton = document.getElementById("skill-view-more-check-box");
const projectCheckButton = document.getElementById(
  "project-view-more-check-box"
);

const projectLinks = document.querySelectorAll("#projects .content a");
const projectModalCloseLinks = document.querySelectorAll(
  "#projects .content .close"
);

const projectLinksValue = [
  "#basic-e-commerce",
  "#computerized-voting-system",
  "#payroll-system",
  "#iwas-corona",
];

const projectModals = document.querySelectorAll("#projects .modal");

function removeActiveImage(images) {
  for (const image of images) {
    image.classList.remove("active");
  }
}

function activateImage(images, index) {
  images[index].classList.add("active");
}

window.addEventListener("resize", resize, true);

mainNavCheckBox.addEventListener("change", function (event) {
  if (mainNavCheckBox.checked) {
    body.classList.add("overflow-hidden");
  } else {
    body.classList.remove("overflow-hidden");
  }
});

function resize() {
  if (window.innerWidth > 780) {
    mainNavCheckBox.checked = false;
    body.classList.remove("overflow-hidden");
    /* if (sections[0].getBoundingClientRect().bottom > window.innerHeight - 1) {
            mainNav.classList.add("bg-dark-50");
        } */
  } /* else {
        mainNav.classList.remove("bg-dark-50");
    } */

  for (const projectModal of projectModals) {
    const screenshotLists = projectModal.querySelectorAll("ul");

    for (const screenshotList of screenshotLists) {
      const viewTypeButtonsPanel = screenshotList.querySelector("div");
      const viewTypeButtons = screenshotList.querySelectorAll("div p");

      if (window.innerWidth > 780) {
        viewTypeButtonsPanel.classList.remove("d-none");

        for (const viewTypeButton of viewTypeButtons) {
          if (
            viewTypeButton.innerHTML === "GRID" &&
            viewTypeButton.getAttribute("class") === "selected"
          ) {
            screenshotList.classList.add("grid");
          }
        }
      } else {
        viewTypeButtonsPanel.classList.add("d-none");
        screenshotList.classList.remove("grid");
      }
    }
  }
}

resize();

if (window.innerWidth <= 780) {
  for (const mainNavItem of mainNavItems) {
    mainNavItem.addEventListener("click", function (event) {
      mainNavCheckBox.checked = false;
    });
  }
}

function onScroll() {
  for (const section of sections) {
    //const windowWidth = window.innerWidth;
    const windowHeight = window.innerHeight;
    const sectionId = section.getAttribute("id");
    const sectionTop = section.getBoundingClientRect().top;
    const sectionBottom = section.getBoundingClientRect().bottom;

    if (sectionId === "intro") {
      if (sectionBottom < windowHeight - 256) {
        introDarkMask.classList.remove("dark-mask");
        introDarkMask.classList.add("bg-dark");
        introProfileImageLayout.classList.add("opacity-0");
        introCaption.classList.add("opacity-0");
      } else {
        introDarkMask.classList.remove("bg-dark");
        introDarkMask.classList.add("dark-mask");
        introProfileImageLayout.classList.remove("opacity-0");
        introCaption.classList.remove("opacity-0");
      }

      /* if (sectionBottom < windowHeight - 1) {
                mainNav.classList.remove("bg-dark-50");
            } else {
                if (windowWidth > 780) {
                    mainNav.classList.add("bg-dark-50");
                }
            } */
    }

    if (sectionId === "bio") {
      if (sectionTop < windowHeight - 256) {
        section.classList.add("show");
      } else {
        section.classList.remove("show");
      }
    }
    if (sectionId === "mission") {
      if (sectionTop < windowHeight - 256) {
        section.classList.add("show");
      } else {
        section.classList.remove("show");
      }
    }
    if (sectionId === "vision") {
      if (sectionTop < windowHeight - 256) {
        section.classList.add("show");
      } else {
        section.classList.remove("show");
      }
    }

    if (sectionId === "corevalues") {
      if (sectionTop < windowHeight - 256) {
        section.classList.add("show");
      } else {
        section.classList.remove("show");
      }
    }

    if (sectionId === "skills") {
      if (sectionTop < windowHeight - 256) {
        section.classList.add("show");
      } /*  else {
                section.classList.remove("show");
            } */
    }

    if (sectionId === "projects") {
      if (sectionTop < windowHeight - 256) {
        section.classList.add("show");
      } /*  else {
                section.classList.remove("show");
            } */
    }

    if (sectionId === "education") {
      if (sectionTop < windowHeight - 256) {
        section.classList.add("show");
      } /*  else {
                section.classList.remove("show");
            } */
    }

    if (sectionId === "experience") {
      if (sectionTop < windowHeight - 256) {
        section.classList.add("show");
      } /*  else {
                section.classList.remove("show");
            } */
    }

    if (sectionId === "awards") {
      if (sectionTop < windowHeight - 256) {
        section.classList.add("show");
      } /*  else {
                section.classList.remove("show");
            } */
    }

    if (sectionId === "contact") {
      if (sectionTop < windowHeight - 256) {
        section.classList.add("show");
      } /*  else {
                section.classList.remove("show");
            } */
    }
  }
}

window.addEventListener("scroll", onScroll);

if (
  projectLinksValue.includes(
    "#" + window.location.href.toString().split("#")[1]
  )
) {
  body.classList.add("modal-open");
}

for (const projectLink of projectLinks) {
  if (projectLinksValue.includes(projectLink.getAttribute("href"))) {
    projectLink.addEventListener("click", function (event) {
      body.classList.add("modal-open");
    });
  }
}

for (const projectModal of projectModals) {
  const screenshotLists = projectModal.querySelectorAll("ul");

  for (const screenshotList of screenshotLists) {
    const viewTypeButtons = screenshotList.querySelectorAll("div p");

    for (const viewTypeButton of viewTypeButtons) {
      viewTypeButton.addEventListener("click", function (event) {
        if (viewTypeButton.getAttribute("class") !== "selected") {
          for (const viewTypeButton of viewTypeButtons) {
            viewTypeButton.classList.remove("selected");
          }
          viewTypeButton.classList.add("selected");

          if (viewTypeButton.innerHTML === "LIST") {
            screenshotList.classList.remove("grid");
          } else if (viewTypeButton.innerHTML === "GRID") {
            screenshotList.classList.add("grid");
          }
        }
      });
    }
  }
}

for (const projectModalCloseLink of projectModalCloseLinks) {
  projectModalCloseLink.addEventListener("click", function (event) {
    body.classList.remove("modal-open");
  });
}

const upBtn = document.querySelector(".up-btn");

window.addEventListener("scroll", () => {
  let scrollPx = Math.round(this.scrollY);
  if (scrollPx > 0) {
    upBtn.classList.add("show");
  } else {
    upBtn.classList.remove("show");
  }
});

// up btn
upBtn.addEventListener("click", () => {
  document.documentElement.scrollTop = 0;
});

const brandContainer = document.querySelector(".brands-container");

const brands = [
  {
    name: {code: "MP", fullName: "Mobile Palengke"},
    img: "./Assets/img/brand_logo/MP.png",
    info: "The Mobile Palengke is an online delivery service established in March 2020, it was created with the safety of customers in mind. We wanted to remove the need for customers to go outside to buy groceries, so we instead offer services that bring the groceries to them. We wanted for customers to experience the freshness of products offered by “Palengkes” such as fruits, vegetables, meat, frozen meat, and other necessities without having to leave the safety of their homes. Mobile Palengke differs from other more established grocery stores and supermarkets by ensuring that the products being delivered to our customers is in optimal freshness and quality",
    links: [
      {
        social: "Facebook",
        link: "https://www.facebook.com/MobilePalengke",
        icon: `<i class="fa-brands fa-facebook"></i>`,
      },
      {
        social: "Instagram",
        link: "https://www.instagram.com/mobilepalengke/",
        icon: `<i class="fa-brands fa-instagram"></i>`,
      },
      {
        social: "Mobile Palengke",
        link: "https://mobilepalengke.org/",
        icon: `<i class="fa-solid fa-globe"></i>`,
      },
    ],
  },
  {
    name: {
      code: "WSAP",
      fullName: "Wedding Suppliers Association of the Philippines",
    },
    img: "./Assets/img/brand_logo/WSAP.png",
    info: "WSAP is an association that wants to secure and protect the wedding industry, the wedding suppliers & members and the clients at the same time. It aims to create a long-lasting impact and add value to the community.",
    links: [
      {
        social: "Facebook",
        link: "https://www.facebook.com/philippineweddingsuppliers.org",
        icon: `<i class="fa-brands fa-facebook"></i>`,
      },
      {
        social: "Instagram",
        link: "https://www.instagram.com/philippineweddingsuppliers/",
        icon: `<i class="fa-brands fa-instagram"></i>`,
      },
      {
        social: "Browser Link",
        link: "https://philippineweddingsuppliers.com/",
        icon: `<i class="fa-solid fa-globe"></i>`,
      },
    ],
  },
  {
    name: {code: "PTE", fullName: "Philippine Travel Expo"},
    img: "./Assets/img/brand_logo/PTE.png",
    info: "Philippine Travel Expo is an online & offline travel expo nationwide to showcase local and international travel agencies, restaurants, hotels, destinations, and many exciting travel services. We share exciting travel guides, tips, and experiences to influence and showcase excellent products and services.",
    links: [
      {
        social: "Facebook",
        link: "https://www.facebook.com/philippinetravelexpo",
        icon: `<i class="fa-brands fa-facebook"></i>`,
      },
      {
        social: "Instagram",
        link: "https://www.instagram.com/philippinetravelexpo/",
        icon: `<i class="fa-brands fa-instagram"></i>`,
      },
      {
        social: "Browser Link",
        link: "https://philippinetravelexpo.com/",
        icon: `<i class="fa-solid fa-globe"></i>`,
      },
    ],
  },
  {
    name: {code: "PVE", fullName: "Philippine Virtual Expo"},
    img: "./Assets/img/brand_logo/PVE.png",
    info: "Through the Philippine Virtual Expo, the experiences everyone is missing will be made possible. We strive to help the community to get back on its feet and move forward in multiple aspects through building a virtual space where the possibilities of networking and trading through various events is limitless.",
    links: [
      {
        social: "Facebook",
        link: "https://www.facebook.com/PhilippineVirtualExpo",
        icon: `<i class="fa-brands fa-facebook"></i>`,
      },
      {
        social: "Instagram",
        link: "https://www.instagram.com/philippinevirtualexpo/",
        icon: `<i class="fa-brands fa-instagram"></i>`,
      },
      {
        social: "Browser Link",
        link: "#",
        icon: `<i class="fa-solid fa-globe"></i>`,
      },
    ],
  },
  {
    name: {code: "PHW", fullName: "Philippine Workshops"},
    img: "./Assets/img/brand_logo/PHW.png",
    info: "Philippine Workshops is your ticket for bigger opportunities by leveling up your knowledge. This is the best platform who organize seminars, trainings and workshops nationwide.",
    links: [
      {
        social: "Facebook",
        link: "https://www.facebook.com/philippineworkshops",
        icon: `<i class="fa-brands fa-facebook"></i>`,
      },
      {
        social: "Instagram",
        link: "https://www.instagram.com/philworkshops/",
        icon: `<i class="fa-brands fa-instagram"></i>`,
      },
      {
        social: "Browser Link",
        link: "https://www.philippineworkshops.com/",
        icon: `<i class="fa-solid fa-globe"></i>`,
      },
    ],
  },
  {
    name: {code: "PMD", fullName: "Philippine Malls Directory"},
    img: "./Assets/img/brand_logo/PMD.png",
    info: "Philippine Malls Directory is not your typical e-commerce site that provides information on malls such as a list of stores, locations, latest updates, and product categories. People could also purchase items and services directly with only one tap. ",
    links: [
      {
        social: "Facebook",
        link: "https://www.facebook.com/PhilippineMallDirectory",
        icon: `<i class="fa-brands fa-facebook"></i>`,
      },
      {
        social: "Instagram",
        link: "https://www.instagram.com/philippinemallsdirectory/",
        icon: `<i class="fa-brands fa-instagram"></i>`,
      },
      {
        social: "Browser Link",
        link: "https://philippinemallsdirectory.com/",
        icon: `<i class="fa-solid fa-globe"></i>`,
      },
    ],
  },
  {
    name: {code: "PHD", fullName: "Philippine Hotels Directory"},
    img: "./Assets/img/brand_logo/PHD.png",
    info: "We offer hotel bookings, reservations and accommodations, transportation and touring services, along with related insurance.",
    links: [
      {
        social: "Facebook",
        link: "https://www.facebook.com/PhilippineHotelsDirectory",
        icon: `<i class="fa-brands fa-facebook"></i>`,
      },
      {
        social: "Instagram",
        link: "https://www.instagram.com/ph_hotelsdirectory/",
        icon: `<i class="fa-brands fa-instagram"></i>`,
      },
      {
        social: "Browser Link",
        link: "https://philippinehotelsdirectory.com/",
        icon: `<i class="fa-solid fa-globe"></i>`,
      },
    ],
  },
  {
    name: {code: "PHS", fullName: "Pahome Services"},
    img: "./Assets/img/brand_logo/PHS.png",
    info: "Pa Home Service PH is an online-based business directory that provides convenience to its users by helping them search for skilled in-home service providers and technicians real time.",
    links: [
      {
        social: "Facebook",
        link: "https://www.facebook.com/pahomeservice",
        icon: `<i class="fa-brands fa-facebook"></i>`,
      },
      {
        social: "Instagram",
        link: "https://www.instagram.com/pahomeserviceph/",
        icon: `<i class="fa-brands fa-instagram"></i>`,
      },
      {
        social: "Browser Link",
        link: "#",
        icon: `<i class="fa-solid fa-globe"></i>`,
      },
    ],
  },

  {
    name: {code: "TRED", fullName: "The Real Estate Directory"},
    img: "./Assets/img/brand_logo/TRED.png",
    info: "Through The Real Estate Directory, it brings convenience to buyers as well as carries exposure to the sellers. Buyers can view hundreds of properties images and features before they even need to schedule a live tour. The company pairs the industry’s top talent with technology to make the searching and selling experience at the highest level. It envisions to engage in selling products and services in the near future in line with its mission of always exceeding the customers’ expectations.",
    links: [
      {
        social: "Facebook",
        link: "https://www.facebook.com/TheRealEstateDirectoryPH/",
        icon: `<i class="fa-brands fa-facebook"></i>`,
      },
      {
        social: "Instagram",
        link: "https://www.instagram.com/therealestatedirectoryph/",
        icon: `<i class="fa-brands fa-instagram"></i>`,
      },
      {
        social: "Browser Link",
        link: "https://philippinerealestatedirectory.com/",
        icon: `<i class="fa-solid fa-globe"></i>`,
      },
    ],
  },
  {
    name: {code: "OPC", fullName: "Online Pasalubong Center"},
    img: "./Assets/img/brand_logo/OPC.png",
    info: "Established in the year 2021, Online Pasalubong formerly known as Online Pasalubong Center is a one-stop shop perfect for your pasalubong cravings, especially with the travel restrictions and possible threats brought by the pandemic. It offers a lot of online pasalubong stores that provide different signature delicacies and souvenirs of the Philippines. Within the comfort of our homes. Online Pasalubong caters to all needs for a sweet and loving pasalubong to all Filipinos nationwide. Shopping for your favorite pasalubong is just at the tips of your fingers.",
    links: [
      {
        social: "Facebook",
        link: "https://www.facebook.com/OnlinePasalubongCenter",
        icon: `<i class="fa-brands fa-facebook"></i>`,
      },
      {
        social: "Instagram",
        link: "",
        icon: `<i class="fa-brands fa-instagram"></i>`,
      },
      {
        social: "Browser Link",
        link: "https://onlinepasalubong.com/",
        icon: `<i class="fa-solid fa-globe"></i>`,
      },
    ],
  },
  {
    name: {code: "APPH", fullName: "Accounting Portal PH"},
    img: "./Assets/img/brand_logo/APPH.png",
    info: "Meeting and collaborating with accounting and non-accounting professionals while acquiring new and relevant accounting knowledge is possible through this portal. It organizes instructive and time-worthy webinars and events with a variety of well-known industry leaders.",
    links: [
      {
        social: "Facebook",
        link: "https://www.facebook.com/AccountingPortal.PH",
        icon: `<i class="fa-brands fa-facebook"></i>`,
      },
      {
        social: "Instagram",
        link: "https://www.instagram.com/accountingportalph/",
        icon: `<i class="fa-brands fa-instagram"></i>`,
      },
      {
        social: "Browser Link",
        link: "https://accountingportalph.com/",
        icon: `<i class="fa-solid fa-globe"></i>`,
      },
    ],
  },
  {
    name: {code: "MRMS", fullName: "Med Results Medical Services"},
    img: "./Assets/img/brand_logo/MRMS.png",
    info: "MedResults is a premier provider of medical services such as selling over the counter medicines, swab testing, medical results under online consultation, booster shots as well as a wide range of care from a variety of licensed medical providers.",
    links: [
      {
        social: "Facebook",
        link: "https://www.facebook.com/MedResultsPH",
        icon: `<i class="fa-brands fa-facebook"></i>`,
      },
      {
        social: "Instagram",
        link: "https://www.instagram.com/medresults.ph/",
        icon: `<i class="fa-brands fa-instagram"></i>`,
      },
      {
        social: "Browser Link",
        link: "#",
        icon: `<i class="fa-solid fa-globe"></i>`,
      },
    ],
  },
  {
    name: {code: "ARED", fullName: "Alabang Real Estate Directory"},
    img: "./Assets/img/brand_logo/ARED.png",
    info: "It is a property management company intended to develop collaborations and use digital marketing to sell condos and properties around Alabang.",
    links: [
      {
        social: "Facebook",
        link: "https://www.facebook.com/AlabangRealEstateDirectory",
        icon: `<i class="fa-brands fa-facebook"></i>`,
      },
      {
        social: "Instagram",
        link: "https://www.instagram.com/alabangrealestatedirectory/",
        icon: `<i class="fa-brands fa-instagram"></i>`,
      },
      {
        social: "Browser Link",
        link: "#",
        icon: `<i class="fa-solid fa-globe"></i>`,
      },
    ],
  },
];

const renderLinks = (arr) => {
  let links = "";
  arr.forEach((arr) => {
    const {link, icon} = arr;
    links += `<li>
  <a target="_blank" href="${link}">${icon}</a>
  </li>`;
  });
  return links;
};

brands.forEach((brand) => {
  const {
    name: {code, fullName},
    links,
    img,
    info,
  } = brand;

  brandContainer.innerHTML += `<div class="brand">
    <div class="text">
      <p>${code}</p>
      <p>${fullName}</p>
      <ul>${renderLinks(links)}</ul>
    </div>
    <div class="img">
      <img src="${img}">
    </div>
    <div class="info">${info}</div>
  </div>`;
});

const allBrands = document.querySelectorAll(".brand");

allBrands.forEach((brand) => {
  brand.addEventListener("click", () => {
    brand.classList.toggle("open");
    brand.lastElementChild.classList.toggle("scroll");
  });
});
