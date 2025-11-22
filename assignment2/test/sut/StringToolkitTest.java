package sut;

import org.junit.jupiter.api.Test;

import static org.junit.jupiter.api.Assertions.*;

class StringToolkitTest {

    @Test
    void reverse_nullString_returnsNull() {
        assertNull(StringToolkit.reverse(null));
    }

    @Test
    void reverse_emptyString_returnsEmptyString() {
        assertEquals("", StringToolkit.reverse(""));
    }

    @Test
    void reverse_validString_returnsReversed() {
        assertEquals("olleH", StringToolkit.reverse("Hello"));
    }

    @Test
    void countVowels_nullString_returnsZero() {
        assertEquals(0, StringToolkit.countVowels(null));
    }

    @Test
    void countVowels_emptyString_returnsZero() {
        assertEquals(0, StringToolkit.countVowels(""));
    }

    @Test
    void countVowels_mixedCaseVowels_returnsCorrectCount() {
        assertEquals(5, StringToolkit.countVowels("AEIOU"));
    }

    @Test
    void countVowels_noVowels_returnsZero() {
        assertEquals(0, StringToolkit.countVowels("Rhythm"));
    }

    @Test
    void isAnagram_nullInputs_returnsFalse() {
        assertFalse(StringToolkit.isAnagram(null, null));
    }

    @Test
    void isAnagram_validAnagram_returnsTrue() {
        assertTrue(StringToolkit.isAnagram("Listen", "Silent"));
    }

    @Test
    void isAnagram_validAnagramWithPunctuationAndCase_returnsTrue() {
        assertTrue(StringToolkit.isAnagram("A decimal point", "I'm a dot in place"));
    }

    @Test
    void isAnagram_notAnagram_returnsFalse() {
        assertFalse(StringToolkit.isAnagram("Hello", "World"));
    }
}