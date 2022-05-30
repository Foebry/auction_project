import { createApi, fetchBaseQuery } from "@reduxjs/toolkit/query/react";

const categoryAPI = createApi({
    reducerPath: "categoyState",
    baseQuery: fetchBaseQuery({
        baseUrl: import.meta.env.VITE_API,
        credentials: "include",
    }),
    endpoints: (builder) => ({
        getCategories: builder.query({
            query: () => "/categories",
            providesTags: ["allCategories"],
        }),
        getCategoryById: builder.query({
            query: (id) => `/category/${id}`,
        }),
        postCategory: builder.mutation({
            query: ({ cat_name }) => ({
                url: `/categories`,
                method: "POST",
                body: {
                    cat_name,
                    csrf: localStorage.getItem("csrf"),
                },
            }),
            invalidatesTags: ["allCategories"],
        }),
        patchCategoryById: builder.mutation({
            query: ({ cat_id, cat_name }) => ({
                url: `/category/${cat_id}`,
                method: "PATCH",
                body: {
                    cat_name,
                    csrf: localStorage.getItem("csrf"),
                },
            }),
            invalidatesTags: ["allCategories"],
        }),
        deleteCategory: builder.mutation({
            query: ({ id }) => ({
                url: `/category/${id}`,
                method: "DELETE",
                body: { csrf: localStorage.getItem("csrf") },
            }),
            invalidatesTags: ["allCategories"],
        }),
    }),
});

export default categoryAPI;
export const {
    useGetCategoriesQuery,
    useGetCategoryByIdQuery,
    usePostCategoryMutation,
    usePatchCategoryByIdMutation,
    useDeleteCategoryMutation,
} = categoryAPI;
