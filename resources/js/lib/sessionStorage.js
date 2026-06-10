export function setItem(key, value) {
  sessionStorage.setItem(key, JSON.stringify(value));
}

export function getItem(key, defaultValue = null) {
  if (sessionStorage.getItem(key) === null) {
    setItem(key, defaultValue);
  }

  let data;

  try {
    data = JSON.parse(sessionStorage.getItem(key));
  } catch (e) {
    console.warn("Value in localStorage is not valid JSON, falling back to default value. Error : " + e);
    data = defaultValue;
  }

  return data;
}