package sut;

public final class StringToolkit {
    private StringToolkit() {}

    // Returns the reversed string;
    // null -> null
    public static String reverse(String s) {
        if (s == null) return null;
        return new StringBuilder(s).reverse().toString();
    }

    // Counts vowels (a, e, i, o, u only), case-insensitive
    public static int countVowels(String s) {
        if (s == null) return 0;
        int count = 0;
        for (char c : s.toLowerCase().toCharArray()) {
            if ("aeiou".indexOf(c) >= 0) count++;
        }
        return count;
    }

    // True if a and b are anagrams ignoring spaces, punctuation, and case
    public static boolean isAnagram(String a, String b) {
        if (a == null || b == null) return false;
        String ca = a.replaceAll("[^A-Za-z0-9]", "").toLowerCase();
        String cb = b.replaceAll("[^A-Za-z0-9]", "").toLowerCase();
        return ca.chars().sorted().collect(StringBuilder::new,
                        StringBuilder::appendCodePoint, StringBuilder::append)
                .toString()
                .equals(
                        cb.chars().sorted().collect(StringBuilder::new,
                                        StringBuilder::appendCodePoint, StringBuilder::append)
                                .toString()

                );
    }
}