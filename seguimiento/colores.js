// Definir colores
let colores = [
    {
        "name": "Black",
        "theme": "dark",
        "group": "Gray",
        "hex": "000000",
        "rgb": "0,0,0"
    },
    {
        "name": "Blue",
        "theme": "dark",
        "group": "Blue",
        "hex": "0000FF",
        "rgb": "0,0,255"
    },
    {
        "name": "BlueViolet",
        "theme": "dark",
        "group": "Blue",
        "hex": "8A2BE2",
        "rgb": "138,43,226"
    },
    {
        "name": "Brown",
        "theme": "dark",
        "group": "Brown",
        "hex": "A52A2A",
        "rgb": "165,42,42"
    },
    {
        "name": "Crimson",
        "theme": "dark",
        "group": "Red",
        "hex": "DC143C",
        "rgb": "220,20,60"
    },
    {
        "name": "DarkBlue",
        "theme": "dark",
        "group": "Blue",
        "hex": "00008B",
        "rgb": "0,0,139"
    },
    {
        "name": "DarkCyan",
        "theme": "dark",
        "group": "Cyan",
        "hex": "008B8B",
        "rgb": "0,139,139"
    },
    {
        "name": "DarkGreen",
        "theme": "dark",
        "group": "Green",
        "hex": "006400",
        "rgb": "0,100,0"
    },
    {
        "name": "DarkMagenta",
        "theme": "dark",
        "group": "Purple",
        "hex": "8B008B",
        "rgb": "139,0,139"
    },
    {
        "name": "DarkOliveGreen",
        "theme": "dark",
        "group": "Green",
        "hex": "556B2F",
        "rgb": "85,107,47"
    },
    {
        "name": "DarkOrchid",
        "theme": "dark",
        "group": "Purple",
        "hex": "9932CC",
        "rgb": "153,50,204"
    },
    {
        "name": "DarkRed",
        "theme": "dark",
        "group": "Red",
        "hex": "8B0000",
        "rgb": "139,0,0"
    },
    {
        "name": "DarkSlateBlue",
        "theme": "dark",
        "group": "Purple",
        "hex": "483D8B",
        "rgb": "72,61,139"
    },
    {
        "name": "DarkSlateGray",
        "theme": "dark",
        "group": "Gray",
        "hex": "2F4F4F",
        "rgb": "47,79,79"
    },
    {
        "name": "DarkSlateGrey",
        "theme": "dark",
        "group": "Gray",
        "hex": "2F4F4F",
        "rgb": "47,79,79"
    },
    {
        "name": "DarkViolet",
        "theme": "dark",
        "group": "Purple",
        "hex": "9400D3",
        "rgb": "148,0,211"
    },
    {
        "name": "DimGray",
        "theme": "dark",
        "group": "Gray",
        "hex": "696969",
        "rgb": "105,105,105"
    },
    {
        "name": "DimGrey",
        "theme": "dark",
        "group": "Gray",
        "hex": "696969",
        "rgb": "105,105,105"
    },
    {
        "name": "FireBrick",
        "theme": "dark",
        "group": "Red",
        "hex": "B22222",
        "rgb": "178,34,34"
    },
    {
        "name": "Green",
        "theme": "dark",
        "group": "Green",
        "hex": "008000",
        "rgb": "0,128,0"
    },
    {
        "name": "Indigo",
        "theme": "dark",
        "group": "Purple",
        "hex": "4B0082",
        "rgb": "75,0,130"
    },
    {
        "name": "LimeGreen",
        "theme": "dark",
        "group": "Green",
        "hex": "32CD32",
        "rgb": "50,205,50"
    },
    {
        "name": "Maroon",
        "theme": "dark",
        "group": "Brown",
        "hex": "800000",
        "rgb": "128,0,0"
    },
    {
        "name": "MediumBlue",
        "theme": "dark",
        "group": "Blue",
        "hex": "0000CD",
        "rgb": "0,0,205"
    },
    {
        "name": "MediumOrchid",
        "theme": "dark",
        "group": "Purple",
        "hex": "BA55D3",
        "rgb": "186,85,211"
    },
    {
        "name": "MediumPurple",
        "theme": "dark",
        "group": "Purple",
        "hex": "9370DB",
        "rgb": "147,112,219"
    },
    {
        "name": "MediumSeaGreen",
        "theme": "dark",
        "group": "Green",
        "hex": "3CB371",
        "rgb": "60,179,113"
    },
    {
        "name": "MediumSlateBlue",
        "theme": "dark",
        "group": "Purple",
        "hex": "7B68EE",
        "rgb": "123,104,238"
    },
    {
        "name": "MediumTurquoise",
        "theme": "dark",
        "group": "Aqua",
        "hex": "48D1CC",
        "rgb": "72,209,204"
    },
    {
        "name": "MediumVioletRed",
        "theme": "dark",
        "group": "Pink",
        "hex": "C71585",
        "rgb": "199,21,133"
    },
    {
        "name": "MidnightBlue",
        "theme": "dark",
        "group": "Blue",
        "hex": "191970",
        "rgb": "25,25,112"
    },
    {
        "name": "Navy",
        "theme": "dark",
        "group": "Blue",
        "hex": "000080",
        "rgb": "0,0,128"
    },
    {
        "name": "Olive",
        "theme": "dark",
        "group": "Green",
        "hex": "808000",
        "rgb": "128,128,0"
    },
    {
        "name": "OliveDrab",
        "theme": "dark",
        "group": "Green",
        "hex": "6B8E23",
        "rgb": "107,142,35"
    },
    {
        "name": "OrangeRed",
        "theme": "dark",
        "group": "Orange",
        "hex": "FF4500",
        "rgb": "255,69,0"
    },
    {
        "name": "Orchid",
        "theme": "dark",
        "group": "Purple",
        "hex": "DA70D6",
        "rgb": "218,112,214"
    },
    {
        "name": "PaleVioletRed",
        "theme": "dark",
        "group": "Pink",
        "hex": "DB7093",
        "rgb": "219,112,147"
    },
    {
        "name": "Peru",
        "theme": "dark",
        "group": "Brown",
        "hex": "cd853f",
        "rgb": "205,133,63"
    },
    {
        "name": "Purple",
        "theme": "dark",
        "group": "Purple",
        "hex": "800080",
        "rgb": "128,0,128"
    },
    {
        "name": "RebeccaPurple",
        "theme": "dark",
        "group": "Purple",
        "hex": "663399",
        "rgb": "102, 51, 153"
    },
    {
        "name": "Red",
        "theme": "dark",
        "group": "Red",
        "hex": "ff0000",
        "rgb": "255,0,0"
    },
    {
        "name": "RosyBrown",
        "theme": "dark",
        "group": "Brown",
        "hex": "bc8f8f",
        "rgb": "188,143,143"
    },
    {
        "name": "RoyalBlue",
        "theme": "dark",
        "group": "Blue",
        "hex": "4169e1",
        "rgb": "65,105,225"
    },
    {
        "name": "SaddleBrown",
        "theme": "dark",
        "group": "Brown",
        "hex": "8b4513",
        "rgb": "139,69,19"
    },
    {
        "name": "SeaGreen",
        "theme": "dark",
        "group": "Green",
        "hex": "2e8b57",
        "rgb": "46,139,87"
    },
    {
        "name": "Sienna",
        "theme": "dark",
        "group": "Brown",
        "hex": "a0522d",
        "rgb": "160,82,45"
    },
    {
        "name": "SlateBlue",
        "theme": "dark",
        "group": "Purple",
        "hex": "6a5acd",
        "rgb": "106,90,205"
    },
    {
        "name": "SlateGray",
        "theme": "dark",
        "group": "Gray",
        "hex": "708090",
        "rgb": "112,128,144"
    },
    {
        "name": "SlateGrey",
        "theme": "dark",
        "group": "Gray",
        "hex": "708090",
        "rgb": "112,128,144"
    },
    {
        "name": "SteelBlue",
        "theme": "dark",
        "group": "Blue",
        "hex": "4682b4",
        "rgb": "70,130,180"
    },
    {
        "name": "Teal",
        "theme": "dark",
        "group": "Cyan",
        "hex": "008080",
        "rgb": "0,128,128"
    },
    {
        "name": "Tomato",
        "theme": "dark",
        "group": "Orange",
        "hex": "ff6347",
        "rgb": "255,99,71"
    },
    {
        "name": "Violet",
        "theme": "dark",
        "group": "Purple",
        "hex": "ee82ee",
        "rgb": "238,130,238"
    }
]