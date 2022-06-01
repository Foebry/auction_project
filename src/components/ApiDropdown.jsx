import { useGetCategoriesQuery } from "../data/categoryAPI";
import { useGetArticlesQuery } from "../data/articleAPI";
import { useContext } from "react";
import { AppContext } from "../context/AppContext";

const ApiDropdown = ({ type, onChange, name }) => {
    const { data: artData } = useGetArticlesQuery({ page_count: 100 });
    const { data: catData } = useGetCategoriesQuery();
    const { updateArticle, updateAuction } = useContext(AppContext);

    return (
        <select onChange={onChange} name={name}>
            {type === "articles" ? (
                <>
                    <option>Select an article</option>
                    {artData?.articles?.map(
                        ({ art_id: id, art_name: name }) => (
                            <option
                                key={id}
                                value={id}
                                selected={updateAuction?.auc_art_id == id}
                            >
                                {name}
                            </option>
                        )
                    )}
                </>
            ) : type === "categories" ? (
                <>
                    <option>Select a category</option>
                    {catData?.map(({ cat_id: id, cat_name: name }) => (
                        <option
                            key={id}
                            value={id}
                            selected={updateArticle?.art_cat_id == id}
                        >
                            {name}
                        </option>
                    ))}
                </>
            ) : (
                ""
            )}
        </select>
    );
};

export default ApiDropdown;
