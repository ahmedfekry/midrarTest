var docDefinition = {
            content: [
                {text: 'Testing Result', style: 'header'},
                {
                    style: 'tableExample',
                    table: {
                        body: [["User_name","Number of tests"],["alhayahlab",221],["mohamed_fawzy",1401],["master_account",1451],["ehegazy",1495]]
                    }
                },
            ],
            styles: {
                header: {
                    fontSize: 18,
                    bold: true,
                    margin: [0, 0, 0, 10]
                },
                tableExample: {
                    margin: [0, 5, 0, 15]
                },
                tableHeader: {
                    bold: true,
                    fontSize: 13,
                    color: 'black'
                }
            },
            defaultStyle: {
                // alignment: 'justify'
            }
        };
        pdfMake.createPdf(docDefinition).download();