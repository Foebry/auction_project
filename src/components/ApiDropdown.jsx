import { useGetCategoriesQuery } from "../data/categoryAPI";
import { useGetArticlesQuery } from "../data/articleAPI";

const ApiDropdown = ({ type, onChange }) => {
    const { data: artData, error: artError } = useGetArticlesQuery();
    const { data: catData, error: catError } = useGetCategoriesQuery();

    type === "artices" && console.log("artData", artData);
    type === "categories" && console.log("catData", catData);

    return (
        <select onChange={onChange}>
            {type === "articles" ? (
                <>
                    <option>Select an article</option>
                    {artData?.map(({ art_id: id, art_name: name }) => (
                        <option key={id} value={id}>
                            {name}
                        </option>
                    ))}
                </>
            ) : type === "categories" ? (
                <>
                    <option>Select a category</option>
                    {catData?.map(({ cat_id: id, cat_name: name }) => (
                        <option key={id} value={id}>
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
