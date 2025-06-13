# Dada Shakespeare: API Documentation

## Database

This API uses the Open Source Shakespeare database. [You can download it here](https://www.opensourceshakespeare.org/downloads/).

## Works

### Return all works

**URL**

/api/works

**Method:**

`GET`

**Success response:**

Code: 200 \
Content:

```json
{
    "message": "Found all works",
    "data" : [
        {
            "WorkID": "12night",
            "Title": "Twelfth Night",
            "LongTitle": "Twelfth Night, Or What You Will",
            "Date": 1599,
            "TotalWords": 19837,
            "TotalParagraphs": 1031
        }
    ]
}
```
Note - route returns 37 items in total (only one shown above for clarity/brevity).

**Error response:**

Code: 404 \
Content:

```json
{
    "message": "No works found"
}
```

### Return single work

**URL**

/api/works/{WorkID}

**Method:**

`GET`

**Success response:**

Code: 200 \
Content:

```json
{
    "message": "Found single work",
    "data": {
        "WorkID": "allswell",
        "Title": "All's Well That Ends Well",
        "LongTitle": "All's Well That Ends Well",
        "Date": 1602,
        "TotalWords": 23009,
        "TotalParagraphs": 1034
    }
}
```

**Error response:**

Code: 404 \
Content: 

```json
{
    "message": "Work not found"
}
```

## Chapters

'Chapters' refers to scenes. Chapters have 'section' data which refers to the act e.g. Section 1 Chapter 2 = Act I Scene II.

### Return all chapters

**URL**

/api/chapters

**Method:**

`GET`

**Success response:**

Code: 200 \
Content:

```json
{
    "message": "Found all chapters",
    "data" : [
        {
            "WorkID": "allswell",
            "ChapterID": 24908,
            "Section": 1,
            "Chapter": 1,
            "Description": "Rousillon. The COUNT&#8217;s palace."
        }
    ]
}
```
Note - route returns 945 items in total (only one shown above for clarity/brevity).

**Error response:**

Code: 404 \
Content:

```json
{
    "message": "No chapters found"
}
```

### Return single chapter

**URL**

/api/chapters/{ChapterID}

**Method:**

`GET`

**Success response:**

Code: 200 \
Content:

```json
{
    "message": "Found single chapter",
    "data": {
        "WorkID": "antonycleo",
        "ChapterID": 24931,
        "Section": 1,
        "Chapter": 1,
        "Description": "Alexandria. A room in CLEOPATRA&#8217;s palace."
    }
}
```

**Error response:**

Code: 404 \
Content:

```json
{
    "message": "Chapter not found"
}
```

## Characters

### Return all characters

**URL**

/api/characters

**Method:**

`GET`

**Success response:**

Code: 200 \
Content:

```json
{
    "message": "Found all characters",
    "data" : [
        {
            "CharID": "1apparition-mac",
            "CharName": "First Apparition",
            "Abbrev": "First Apparition",
            "Works": "macbeth",
            "Description": "",
            "SpeechCount": 1
        }
    ]
}
```
Note - route returns 1265 items in total (only one shown above for clarity/brevity).

### Return single character

**URL**

/api/characters/{CharID}

**Method:**

`GET`

**Success response:**

Code: 200 \
Content:

```json
{
    "message": "Found single character",
    "data": {
        "CharID": "macbeth",
        "CharName": "Macbeth",
        "Abbrev": "MACBETH",
        "Works": "macbeth",
        "Description": "General of the King's army",
        "SpeechCount": 146
    }
}
```

**Error response:**

Code: 404 \
Content:

```json
{
    "message": "Character not found"
}
```

### Return all characters for a specified work

**URL**

/api/characters/work/{WorkID}

**Method:**

`GET`

**Success response:**

Code: 200 \
Content:

```json
{
    "message": "Found all characters for selected play",
    "data": [
        {
            "CharID": "aguecheek",
            "CharName": "Sir Andrew Aguecheek",
            "Abbrev": "SIR ANDREW",
            "Works": "12night",
            "Description": "",
            "SpeechCount": 88
        }
    ]
}
```

Note - example above returns 18 items in total (only one shown above for clarity/brevity).


## Paragraphs

'Paragraphs' refers to stage directions and speeches (note - whole speeches, not individual lines within those speeches).

### Return all paragraphs

Warning: there are quite a lot of speeches (35,629) in the entire works of Shakespeare, so trying to return all paragraphs might take a very long time.

**URL**

/api/paragraphs

**Method:**

`GET`

**Success response:**

Code: 200 \
Content:

```json
{
    "message": "Found all paragraphs",
    "data" : [
        {
            "WorkID":"allswell",
            "ParagraphID":859862,
            "ParagraphNum":1,
            "CharID":"xxx",
            "PlainText":"Enter BERTRAM, the COUNTESS of Rousillon, HELENA,]\n[p]and LAFEU, all in black]\n",
            "PhoneticText":" ENTR BRTRM 0 KNTS OF RSLN HLN ANT LF AL IN BLK ",
            "StemText":" enter bertram the countess of rousillon helena and lafeu all in black ",
            "ParagraphType":"b",
            "Section":1,
            "Chapter":1,
            "CharCount":79,
            "WordCount":12
        }
    ]
}
```
Note - route returns 35,629 items in total (only one shown above for clarity/brevity).

**Error response:**

Code: 404 \
Content:

```json
{
    "message": "No chapters found"
}
```

### Return single paragraph

**URL**

/api/paragraphs/{ParagraphID}

**Method:**

`GET`

**Success response:**

Code: 200 \
Content:

```json
{
    "message": "Found single paragraph",
    "data": {
        "WorkID": "allswell",
        "ParagraphID": 859881,
        "ParagraphNum": 54,
        "CharID": "Countess-aw",
        "PlainText": "If the living be enemy to the grief, the excess\n[p]makes it soon mortal.\n",
        "PhoneticText": " IF 0 LFNK B ENM T 0 KRF 0 EKSSS MKS IT SN MRTL ",
        "StemText": " if the live be enemi to the grief the excess make it soon mortal ",
        "ParagraphType": "b",
        "Section": 1,
        "Chapter": 1,
        "CharCount": 73,
        "WordCount": 14
    }
}
```

**Error response:**

Code: 404 \
Content:

```json
{
    "message": "Paragraph not found"
}
```

### Return all paragraphs for a specified work

**URL**

/api/paragraphs/work/{WorkID}

**Method:**

`GET`

**Success response:**

Code: 200 \
Content:

```json
{
    "message": "Found all paragraphs for selected play",
    "data": [
        {
            "WorkID": "romeojuliet",
            "ParagraphID": 886858,
            "ParagraphNum": 1,
            "CharID": "chorus-rj",
            "PlainText": "Two households, both alike in dignity,\r\n[p]In fair Verona, where we lay our scene,\r\n[p]From ancient grudge break to new mutiny,\r\n[p]Where civil blood makes civil hands unclean.\r\n[p]From forth the fatal loins of these two foes\r\n[p]A pair of star-cross'd lovers take their life;\r\n[p]Whose misadventured piteous overthrows\r\n[p]Do with their death bury their parents' strife.\r\n[p]The fearful passage of their death-mark'd love,\r\n[p]And the continuance of their parents' rage,\r\n[p]Which, but their children's end, nought could remove,\r\n[p]Is now the two hours' traffic of our stage;\r\n[p]The which if you with patient ears attend,\r\n[p]What here shall miss, our toil shall strive to mend.\r\n",
            "PhoneticText": " TW HSHLTS B0 ALK IN TKNT IN FR FRN HR W L OR SN FRM ANSNT KRJ BRK T N MTN HR SFL BLT MKS SFL HNTS UNKLN FRM FR0 0 FTL LNS OF 0S TW FS A PR OF STRKRST LFRS TK 0R LF HL MSTFNTRT PTS OFR0RS T W0 0R T0 BR 0R PRNTS STRF 0 FRFL PSJ OF 0R T0MRKT LF ANT 0 KNTNNS OF 0R PRNTS RJ HX BT 0R XLTRNS ENT NFT KLT RMF IS N 0 TW HRS TRFK OF OR STJ 0 HX IF Y W0 PTNT ERS ATNT HT HR XL MS OR TL XL STRF T MNT ",
            "StemText": " two household both alik in digniti in fair verona where we lai our scene from ancient grudg break to new mutini where civil blood make civil hand unclean from forth the fatal loin of these two foe a pair of starcrossd lover take their life whole misadventur piteou overthrow do with their death buri their parent strife the fear passag of their deathmarkd love and the continu of their parent rage which but their children end nought could remov i now the two hour traffic of our stage the which if you with patient ear attend what here shall miss our toil shall strive to mend ",
            "ParagraphType": "b",
            "Section": 0,
            "Chapter": 1,
            "CharCount": 669,
            "WordCount": 106,
            "CharName": "Chorus",
            "Abbrev": "Chorus",
            "Works": "romeojuliet",
            "Description": "",
            "SpeechCount": 2
        }
    ]
}
```

Note - example above returns 989 items in total (only one shown above for clarity/brevity).

**Error response:**

Code: 404 \
Content:

```json
{
    "message" : "Play not found"
}
```

### Return all paragraphs for a specified character

**URL**

/api/paragraphs/character/{CharID}

**Method:**

`GET`

**Success response:**

Code: 200 \
Content:

```json
{
    "message": "Found all paragraphs for selected character",
    "data": [
        {
            "WorkID": "macbeth",
            "ParagraphID": 877346,
            "ParagraphNum": 138,
            "CharID": "macbeth",
            "PlainText": "So foul and fair a day I have not seen.\n",
            "PhoneticText": " S FL ANT FR A T I HF NT SN ",
            "StemText": " so foul and fair a dai i have not seen ",
            "ParagraphType": "b",
            "Section": 1,
            "Chapter": 3,
            "CharCount": 40,
            "WordCount": 10
        }
    ]
}
```

Note - example above returns 146 items in total (only one shown above for clarity/brevity).

**Error response:**

Code: 404 \
Content:

```json
{
    "message" : "Character not found"
}
```

