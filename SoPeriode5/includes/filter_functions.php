<select name="genre" class="genre-filter" onchange="this.form.submit()">
                        <option value="">Select Genre</option>
                        <?php
                        // Fetch genres from the database and populate the dropdown
                        $genres_query = "SELECT * FROM genres";
                        $genres_result = $conn->query($genres_query);
                        while ($genre_row = $genres_result->fetch_assoc()) {
                            $selected = (isset($_GET['genre']) && $_GET['genre'] == $genre_row['GenreID']) ? "selected" : "";
                            echo "<option value='{$genre_row['GenreID']}' $selected>{$genre_row['Genre']}</option>";
                        }
                        ?>
                    </select>
                    <select name="release_date" class="release-date-filter" onchange="this.form.submit()">
                        <option value="">Select Release Date</option>
                        <?php
                        // Fetch release dates from the database and populate the dropdown
                        $release_dates_query = "SELECT DISTINCT Release_Date FROM film";
                        $release_dates_result = $conn->query($release_dates_query);
                        while ($release_date_row = $release_dates_result->fetch_assoc()) {
                            $selected = (isset($_GET['release_date']) && $_GET['release_date'] == $release_date_row['Release_Date']) ? "selected" : "";
                            echo "<option value='{$release_date_row['Release_Date']}' $selected>{$release_date_row['Release_Date']}</option>";
                        }
                        ?>
                    </select>
                    <select name="director" class="director-filter" onchange="this.form.submit()">
                        <option value="">Select Director</option>
                        <?php
                        // Fetch directors from the database and populate the dropdown
                        $directors_query = "SELECT DISTINCT Director FROM film";
                        $directors_result = $conn->query($directors_query);
                        while ($director_row = $directors_result->fetch_assoc()) {
                            $selected = (isset($_GET['director']) && $_GET['director'] == $director_row['Director']) ? "selected" : "";
                            echo "<option value='{$director_row['Director']}' $selected>{$director_row['Director']}</option>";
                        }
                        ?>
                    </select>